<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="page-title">Dashboard</h2>
            <p class="page-subtitle">Track clients, generated links, and click activity from one tidy workspace.</p>
        </div>
    </x-slot>

    <div class="py-8 sm:py-10">
        <div class="mx-auto max-w-7xl space-y-6 px-4 sm:px-6 lg:px-8">
            @auth
                @if(auth()->user()->hasRole('SuperAdmin'))
                    <section class="surface">
                        <div class="surface-header">
                            <div>
                                <h3 class="text-lg font-semibold text-slate-950">Clients</h3>
                                <p class="mt-1 text-sm text-slate-500">Company activity and link performance at a glance.</p>
                            </div>

                            <a class="btn" href="{{ route('companies.invite') }}">Invite</a>
                        </div>

                        <div class="surface-body">
                            <div class="overflow-x-auto table-wrap">
                                <table class="data-table">
                                    <thead>
                                        <tr>
                                            <th>Client Name</th>
                                            <th class="text-center">Users</th>
                                            <th class="text-center">Total Generated URLs</th>
                                            <th class="text-center">Total URL Hits</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($clients as $client)
                                            <tr>
                                                <td>
                                                    <div class="font-semibold text-slate-900">{{ $client->name }}</div>
                                                    <div class="text-xs text-slate-500">{{ $client->email }}</div>
                                                </td>
                                                <td class="text-center"><span class="metric-pill">{{ $client->users_count ?? 0 }}</span></td>
                                                <td class="text-center"><span class="metric-pill">{{ $client->total_urls ?? 0 }}</span></td>
                                                <td class="text-center"><span class="metric-pill">{{ $client->total_hits ?? 0 }}</span></td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <div class="mt-4 text-sm text-slate-500">
                                Showing {{ $clients->count() }} of {{ $clients->total() }}
                            </div>
                        </div>
                    </section>
                @endif
            @endauth

            <section class="surface">
                <div class="surface-header">
                    <div>
                        <h3 class="text-lg font-semibold text-slate-950">Generated Short URLs</h3>
                        <p class="mt-1 text-sm text-slate-500">Monitor every short link, source URL, and hit count.</p>
                    </div>

                    <div class="flex flex-col gap-3 sm:flex-row sm:items-center">
                        @if(auth()->user()->hasRole('Admin') || auth()->user()->hasRole('TeamMember'))
                            <a class="btn" href="{{ route('urls.generate') }}">Generate</a>
                        @endif

                        <form method="GET" action="{{ route('urls.download') }}" class="flex flex-col gap-3 sm:flex-row sm:items-center">
                            <select name="interval" class="field-control sm:w-44">
                                <option value="today" {{ request('interval') == 'today' ? 'selected' : '' }}>Today</option>
                                <option value="week" {{ request('interval') == 'week' ? 'selected' : '' }}>Last 7 Days</option>
                                <option value="month" {{ request('interval') == 'month' ? 'selected' : '' }}>This Month</option>
                                <option value="last_month" {{ request('interval') == 'last_month' ? 'selected' : '' }}>Last Month</option>
                                <option value="year" {{ request('interval') == 'year' ? 'selected' : '' }}>This Year</option>
                                <option value="all" {{ request('interval') == 'all' ? 'selected' : '' }}>All</option>
                            </select>

                            <button type="submit" class="btn-secondary">Download CSV</button>
                        </form>
                    </div>
                </div>

                <div class="surface-body">
                    <div class="overflow-x-auto table-wrap">
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>Short URL</th>
                                    <th>Long URL</th>
                                    <th class="text-center">Hits</th>
                                    @if (auth()->user()->hasRole('Admin'))
                                        <th class="text-center">User</th>
                                    @endif
                                    @if (auth()->user()->hasRole('SuperAdmin'))
                                        <th class="text-center">Company</th>
                                    @endif
                                    <th class="text-center">Created On</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($urls as $url)
                                    <tr>
                                        <td>
                                            <a class="font-semibold text-sky-700 hover:text-sky-900" href="{{ url('u/'.$url->short_code) }}" target="_blank">
                                                {{ url('u/'.$url->short_code) }}
                                            </a>
                                        </td>
                                        <td title="{{ $url->original_url }}" class="max-w-md">
                                            <span class="block truncate">{{ \Illuminate\Support\Str::limit($url->original_url, 64) }}</span>
                                        </td>
                                        <td class="text-center"><span class="metric-pill">{{ $url->hits }}</span></td>
                                        @if (auth()->user()->hasRole('Admin'))
                                            <td class="text-center">{{ $url->user->name ?? '-' }}</td>
                                        @endif
                                        @if (auth()->user()->hasRole('SuperAdmin'))
                                            <td class="text-center">{{ $url->company->name ?? '-' }}</td>
                                        @endif
                                        <td class="text-center text-slate-500">{{ $url->created_at->timezone('Asia/Kolkata')->format('d M Y') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>

            @auth
                @if(auth()->user()->hasRole('Admin'))
                    <section class="surface">
                        <div class="surface-header">
                            <div>
                                <h3 class="text-lg font-semibold text-slate-950">Team Members</h3>
                                <p class="mt-1 text-sm text-slate-500">Invite teammates and review their link output.</p>
                            </div>

                            <a class="btn" href="{{ route('companies.admin') }}">Invite</a>
                        </div>

                        <div class="surface-body">
                            <div class="overflow-x-auto table-wrap">
                                <table class="data-table">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th class="text-center">Email</th>
                                            <th class="text-center">Role</th>
                                            <th class="text-center">Total Generated URLs</th>
                                            <th class="text-center">Total URL Hits</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($users as $user)
                                            <tr>
                                                <td class="font-semibold text-slate-900">{{ $user->name }}</td>
                                                <td class="text-center">{{ $user->email }}</td>
                                                <td class="text-center">{{ $user->roles()->first()->name }}</td>
                                                <td class="text-center"><span class="metric-pill">{{ $user->total_urls ?? 0 }}</span></td>
                                                <td class="text-center"><span class="metric-pill">{{ $user->total_hits ?? 0 }}</span></td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <div class="mt-4 text-sm text-slate-500">
                                Showing {{ $users->count() }} of {{ $users->total() }}
                            </div>
                        </div>
                    </section>
                @endif
            @endauth
        </div>
    </div>
</x-app-layout>
