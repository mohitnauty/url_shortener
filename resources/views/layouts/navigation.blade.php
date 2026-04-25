<nav x-data="{ open: false }" class="border-b border-white/70 bg-white/85 backdrop-blur">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}" class="inline-flex items-center gap-3">
                        <span class="inline-flex h-10 w-10 items-center justify-center rounded-lg bg-sky-600 text-white shadow-sm shadow-sky-200">
                            <x-application-logo class="block h-6 w-6 fill-current" />
                        </span>
                        <span class="hidden text-sm font-bold uppercase tracking-wide text-slate-800 lg:inline">Sembark URL</span>
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        {{ __('Dashboard') }}
                    </x-nav-link>

                    <!-- @auth
                        @if(auth()->user()->hasRole('SuperAdmin'))
                            <x-nav-link :href="route('companies.create')">
                                Create Company
                            </x-nav-link>
                        @endif
                    @endauth -->
                </div>
            </div>

            <!-- Account Actions -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <div class="flex items-center gap-3 rounded-md border border-slate-200 bg-white px-3 py-2 shadow-sm">
                    <span class="max-w-40 truncate text-sm font-semibold text-slate-700">{{ Auth::user()->name }}</span>

                    <a href="{{ route('profile.edit') }}" class="text-sm font-semibold text-slate-600 transition hover:text-slate-950 focus:outline-none focus:ring-2 focus:ring-sky-500 focus:ring-offset-2">
                        {{ __('Profile') }}
                    </a>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf

                        <button type="submit" class="text-sm font-semibold text-slate-600 transition hover:text-slate-950 focus:outline-none focus:ring-2 focus:ring-sky-500 focus:ring-offset-2">
                            {{ __('Sign Out') }}
                        </button>
                    </form>
                </div>
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center rounded-md p-2 text-slate-500 transition hover:bg-slate-100 hover:text-slate-700 focus:bg-slate-100 focus:text-slate-700 focus:outline-none">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <button type="submit" class="block w-full border-l-4 border-transparent py-2 ps-3 pe-4 text-start text-base font-medium text-gray-600 transition duration-150 ease-in-out hover:border-gray-300 hover:bg-gray-50 hover:text-gray-800 focus:border-gray-300 focus:bg-gray-50 focus:text-gray-800 focus:outline-none">
                        {{ __('Log Out') }}
                    </button>
                </form>
            </div>
        </div>
    </div>
</nav>
