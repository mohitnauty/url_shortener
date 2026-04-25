<?php

namespace App\Http\Controllers;

use App\Models\Companies;
use App\Models\ShortUrl;
use App\Models\ShortUrls;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
         $clients = Companies::withCount('users')
            ->withCount('shortUrls as total_urls')
            ->withSum('shortUrls as total_hits', 'hits')
            ->paginate(10);

        $users = User::where('company_id', auth()->user()->company_id)
            ->where('id', '!=', auth()->user()->id)
            ->withCount('shortUrls as total_urls')
            ->withSum('shortUrls as total_hits', 'hits')
            ->paginate(10);

        if(auth()->user()->hasRole('SuperAdmin')) {
            $urls = ShortUrls::with('company', 'user')
                ->latest()
                ->get();
        }elseif(auth()->user()->hasRole('Admin')) {
            $urls = ShortUrls::with('company', 'user')
                ->where('company_id', auth()->user()->company_id)
                ->latest()
                ->get();
        }else{
            $urls = ShortUrls::with('company', 'user')
                ->where('user_id', auth()->user()->id)
                ->latest()
                ->get();
        }

        return view('dashboard', compact('urls', 'clients', 'users'));
    }
}
