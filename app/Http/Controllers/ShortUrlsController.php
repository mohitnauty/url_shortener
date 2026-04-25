<?php

namespace App\Http\Controllers;

use App\Models\ShortUrls;
use App\Services\ShortUrlsService;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ShortUrlsController extends Controller
{
    public function index()
    {
        return view('short-urls.index');
    }

    public function generate(Request $request, ShortUrlsService $service)
    {
        if ($request->isMethod('get')) {
            return view('short-urls.generate');
        }

        $request->validate([
            'original_url' => 'required|url'
        ]);

        $user = auth()->user();

        try {
            $shortUrl = DB::transaction(function () use ($request, $service, $user) {

                $record = ShortUrls::create([
                    'original_url' => $request->original_url,
                    'user_id'      => $user->id,
                    'company_id'   => $user->company_id,
                ]);

                $code = $service->encode($record->id);

                $record->update([
                    'short_code' => $code
                ]);

                return $record;
            });

        } catch (\Exception $e) {
            Log::error('Short URL generation failed: ' . $e->getMessage());
            return back()->with('error', 'Something went wrong. Please try again.');
        }

        return redirect()
            ->route('dashboard')
            ->with('success', 'URL generated successfully');
    }

    public function redirect($code)
    {
        $shortUrl = cache()->remember("short_url:$code", 3600, function () use ($code) {
            return ShortUrls::where('short_code', $code)->firstOrFail();
        });

        dispatch(function () use ($shortUrl) {
            $shortUrl->increment('hits');
        });

        return redirect()->away($shortUrl->original_url);
    }


    public function downloadCsv(): StreamedResponse
    {
        $interval = request('interval', 'all');

        if(auth()->user()->hasRole('SuperAdmin')) {
            $query = ShortUrls::query();
        }elseif(auth()->user()->hasRole('Admin')) {
            $query = ShortUrls::where('company_id', auth()->user()->company_id);
        }else{
            $query = ShortUrls::where('user_id', auth()->user()->id);
        }
        
        switch ($interval) {
            case 'today':
                $query->whereDate('created_at', Carbon::today());
                break;

            case 'week':
                $query->where('created_at', '>=', Carbon::now()->subDays(7));
                break;

            case 'month':
                $query->whereMonth('created_at', Carbon::now()->month)
                      ->whereYear('created_at', Carbon::now()->year);
                break;

            case 'last_month':
                $lastMonth = Carbon::now()->subMonth();
                $query->whereMonth('created_at', $lastMonth->month)
                      ->whereYear('created_at', $lastMonth->year);
                break;

            case 'year':
                $query->whereYear('created_at', Carbon::now()->year);
                break;

            case 'all':
            default:
                // no filter
                break;
        }

        $fileName = 'short_urls_' . $interval . '_' . now()->format('Ymd_His') . '.csv';

        $headers = [
            'Content-Type'        => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$fileName\"",
        ];

        $callback = function () use ($query) {
            $handle = fopen('php://output', 'w');
            $commonColumns = [
                'Short URL',
                'Original URL',
                'Hits',
                'Created On',
            ];
            if(auth()->user()->hasRole('SuperAdmin')) {
                $columns = array_merge($commonColumns, ['Company']);
            }elseif(auth()->user()->hasRole('Admin')) {
                $columns = array_merge($commonColumns, ['User']);
            }else{
                $columns = $commonColumns;
            }
            // CSV header
            fputcsv($handle, $columns);

            $query->orderBy('id', 'desc')
                ->chunk(500, function ($urls) use ($handle) {
                    foreach ($urls as $url) {
                        $common = [
                            url('u/' . $url->short_code),
                            $url->original_url,
                            $url->hits,
                            $url->created_at
                                ->timezone(config('app.timezone'))
                                ->format('d M Y H:i'),
                        ];
                        if(auth()->user()->hasRole('SuperAdmin')) {
                            $common[] = $url->company->name;
                        }elseif(auth()->user()->hasRole('Admin')) {
                            $common[] = $url->user->name;
                        }
                        fputcsv($handle, $common);
                    }
                });

            fclose($handle);
        };

        return response()->stream($callback, 200, $headers);
    }
}
