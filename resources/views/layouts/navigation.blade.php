<nav x-data="{ open: false }" class="bg-emerald-600 border-b border-emerald-700 shadow">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <img src="{{ asset('logo.png') }}" alt="Logo SIMADE" class="h-[45px] w-auto object-contain mr-3">
                    <a href="{{ session('active_role') === 'dosen' ? route('dashboard.dosen') : route('dashboard.mahasiswa') }}" class="text-white font-bold text-xl tracking-wider flex items-center">
                        SIMADE
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="session('active_role') === 'dosen' ? route('dashboard.dosen') : route('dashboard.mahasiswa')" :active="request()->routeIs('dashboard.*')" class="text-emerald-100 hover:text-white hover:border-white focus:text-white focus:border-white {{ request()->routeIs('dashboard.*') ? 'border-white text-white' : 'border-transparent' }}">
                        {{ __('Dashboard') }}
                    </x-nav-link>
                    
                    @if(session('active_role') === 'mahasiswa' && (Auth::user()->role === 'admin' || Auth::user()->role === 'dosen'))
                    <x-nav-link :href="route('mahasiswa.index')" :active="request()->routeIs('mahasiswa.index') || request()->routeIs('mahasiswa.show') || request()->routeIs('mahasiswa.create') || request()->routeIs('mahasiswa.edit')" class="text-emerald-100 hover:text-white hover:border-white focus:text-white focus:border-white {{ request()->routeIs('mahasiswa.index') ? 'border-white text-white' : 'border-transparent' }}">
                        Data Mahasiswa
                    </x-nav-link>
                    <x-nav-link :href="route('mahasiswa.laporan')" :active="request()->routeIs('mahasiswa.laporan*')" class="text-emerald-100 hover:text-white hover:border-white focus:text-white focus:border-white {{ request()->routeIs('mahasiswa.laporan*') ? 'border-white text-white' : 'border-transparent' }}">
                        Laporan
                    </x-nav-link>
                    @endif
                    
                    @if(session('active_role') === 'dosen' && Auth::user()->role === 'admin')
                    <x-nav-link :href="route('dosen.index')" :active="request()->routeIs('dosen.*')" class="text-emerald-100 hover:text-white hover:border-white focus:text-white focus:border-white {{ request()->routeIs('dosen.*') ? 'border-white text-white' : 'border-transparent' }}">
                        Data Dosen
                    </x-nav-link>
                    @endif
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-emerald-100 bg-emerald-600 hover:text-white focus:outline-none transition ease-in-out duration-150">
                            <div>{{ Auth::user()?->name }}</div>

                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <x-dropdown-link :href="route('pilih-role')">
                            {{ __('Ganti Role') }}
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
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
            <x-responsive-nav-link :href="session('active_role') === 'dosen' ? route('dashboard.dosen') : route('dashboard.mahasiswa')" :active="request()->routeIs('dashboard.*')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
            
            @if(session('active_role') === 'mahasiswa' && (Auth::user()->role === 'admin' || Auth::user()->role === 'dosen'))
            <x-responsive-nav-link :href="route('mahasiswa.index')" :active="request()->routeIs('mahasiswa.index')">
                Data Mahasiswa
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('mahasiswa.laporan')" :active="request()->routeIs('mahasiswa.laporan*')">
                Laporan Mahasiswa
            </x-responsive-nav-link>
            @endif
            
            @if(session('active_role') === 'dosen' && Auth::user()->role === 'admin')
            <x-responsive-nav-link :href="route('dosen.index')" :active="request()->routeIs('dosen.*')">
                Data Dosen
            </x-responsive-nav-link>
            @endif
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800">{{ Auth::user()?->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()?->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <x-responsive-nav-link :href="route('pilih-role')">
                    {{ __('Ganti Role') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
