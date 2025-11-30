{{-- Navbar --}}
<nav class="bg-white shadow-sm sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
            {{-- Logo --}}
            <div class="flex-shrink-0">
                <a href="/" class="flex items-center space-x-2">
                    {{-- Logo Icon --}}
                    <svg class="w-8 h-8 text-[rgba(10,154,242,1)]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                    </svg>
                    <span class="text-2xl font-bold text-[rgba(10,154,242,1)]">Tiketku</span>
                </a>
            </div>
            
            {{-- Desktop Menu --}}
            <div class="hidden md:flex items-center space-x-8">
                <a href="/" class="text-gray-700 hover:text-[rgba(10,154,242,1)] transition-colors font-medium">Beranda</a>
                <a href="#promo" class="text-gray-700 hover:text-[rgba(10,154,242,1)] transition-colors font-medium">Promo</a>
                <a href="#rute" class="text-gray-700 hover:text-[rgba(10,154,242,1)] transition-colors font-medium">Rute</a>
                {{-- <a href="#bantuan" class="text-gray-700 hover:text-[rgba(10,154,242,1)] transition-colors font-medium">Bantuan</a> --}}
            </div>
            
            {{-- Desktop Auth Buttons --}}
            <div class="hidden md:flex items-center space-x-4">
                @guest
                    <a href="{{ route('login') }}" class="px-4 py-2 border-2 border-[rgba(10,154,242,1)] text-[rgba(10,154,242,1)] rounded-lg font-medium hover:bg-[rgba(10,154,242,0.1)] transition-all">
                        Masuk
                    </a>
                    <a href="{{ route('register') }}" class="px-4 py-2 bg-[rgba(10,154,242,1)] text-white rounded-lg font-medium hover:bg-[rgba(10,154,242,0.9)] transition-all shadow-md hover:shadow-lg">
                        Daftar
                    </a>
                @else
                    <!-- Profile Dropdown -->
                    <div class="relative ml-3">
                        <div>
                            <button type="button" class="flex items-center gap-2 max-w-xs bg-white rounded-full focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[rgba(10,154,242,1)] transition-all" id="user-menu-button" aria-expanded="false" aria-haspopup="true">
                                <span class="sr-only">Open user menu</span>
                                <div class="h-9 w-9 rounded-full bg-gradient-to-br from-[rgba(10,154,242,1)] to-blue-600 flex items-center justify-center text-white font-bold shadow-md">
                                    {{ substr(Auth::user()->name, 0, 1) }}
                                </div>
                                <div class="hidden md:flex flex-col items-start">
                                    <span class="text-sm font-semibold text-gray-700 leading-none">{{ Auth::user()->name }}</span>
                                    <span class="text-xs text-gray-500 leading-none mt-1">{{ ucfirst(Auth::user()->role) }}</span>
                                </div>
                                <svg class="hidden md:block w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>
                        </div>

                        <!-- Dropdown menu -->
                        <div id="user-menu-dropdown" class="hidden origin-top-right absolute right-0 mt-2 w-56 rounded-xl shadow-2xl py-1 bg-white ring-1 ring-black ring-opacity-5 focus:outline-none z-50 transform transition-all duration-200 ease-out" role="menu" aria-orientation="vertical" aria-labelledby="user-menu-button" tabindex="-1">
                            <div class="px-4 py-3 border-b border-gray-100 bg-gray-50 rounded-t-xl">
                                <p class="text-xs text-gray-500 uppercase tracking-wider font-semibold">Akun</p>
                                <p class="text-sm font-medium text-gray-900 truncate mt-1">{{ Auth::user()->email }}</p>
                            </div>
                            
                            <div class="py-1">
                                @if(Auth::user()->role === 'admin')
                                    <a href="{{ route('admin.dashboard') }}" class="group flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-blue-50 hover:text-[rgba(10,154,242,1)] transition-colors" role="menuitem">
                                        <svg class="mr-3 h-5 w-5 text-gray-400 group-hover:text-[rgba(10,154,242,1)]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path>
                                        </svg>
                                        Dashboard Admin
                                    </a>
                                @else
                                    <a href="{{ route('bookings.index') }}" class="group flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-blue-50 hover:text-[rgba(10,154,242,1)] transition-colors" role="menuitem">
                                        <svg class="mr-3 h-5 w-5 text-gray-400 group-hover:text-[rgba(10,154,242,1)]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"></path>
                                        </svg>
                                        Pesanan Saya
                                    </a>
                                @endif
                                
                                <a href="{{ route('settings.index') }}" class="group flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-blue-50 hover:text-[rgba(10,154,242,1)] transition-colors" role="menuitem">
                                    <svg class="mr-3 h-5 w-5 text-gray-400 group-hover:text-[rgba(10,154,242,1)]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                    Pengaturan
                                </a>
                            </div>

                            <div class="border-t border-gray-100 py-1">
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="group flex w-full items-center px-4 py-2 text-sm text-red-600 hover:bg-red-50 transition-colors" role="menuitem">
                                        <svg class="mr-3 h-5 w-5 text-red-400 group-hover:text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                        </svg>
                                        Keluar
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endguest
            </div>
            
            {{-- Mobile Menu Button --}}
            <div class="md:hidden">
                <button type="button" id="mobile-menu-btn" class="text-gray-700 hover:text-[rgba(10,154,242,1)] focus:outline-none">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
            </div>
        </div>
        
        {{-- Mobile Menu --}}
        <div id="mobile-menu" class="hidden md:hidden border-t border-gray-100">
            <div class="px-2 pt-2 pb-3 space-y-1">
                <a href="/" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-[rgba(10,154,242,1)] hover:bg-gray-50">Beranda</a>
                <a href="#promo" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-[rgba(10,154,242,1)] hover:bg-gray-50">Promo</a>
                <a href="#rute" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-[rgba(10,154,242,1)] hover:bg-gray-50">Rute</a>
                {{-- <a href="#bantuan" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-[rgba(10,154,242,1)] hover:bg-gray-50">Bantuan</a> --}}
                
                <div class="pt-4 pb-3 border-t border-gray-100 mt-2">
                    @guest
                        <div class="space-y-2 px-2">
                            <a href="{{ route('login') }}" class="block px-3 py-2 border-2 border-[rgba(10,154,242,1)] text-[rgba(10,154,242,1)] rounded-lg font-medium text-center">Masuk</a>
                            <a href="{{ route('register') }}" class="block px-3 py-2 bg-[rgba(10,154,242,1)] text-white rounded-lg font-medium text-center">Daftar</a>
                        </div>
                    @else
                        <div class="flex items-center px-4 mb-3">
                            <div class="flex-shrink-0">
                                <div class="h-10 w-10 rounded-full bg-gradient-to-br from-[rgba(10,154,242,1)] to-blue-600 flex items-center justify-center text-white font-bold shadow-md text-lg">
                                    {{ substr(Auth::user()->name, 0, 1) }}
                                </div>
                            </div>
                            <div class="ml-3">
                                <div class="text-base font-medium text-gray-800">{{ Auth::user()->name }}</div>
                                <div class="text-sm font-medium text-gray-500">{{ Auth::user()->email }}</div>
                            </div>
                        </div>
                        
                        <div class="space-y-1 px-2">
                            @if(Auth::user()->role === 'admin')
                                <a href="{{ route('admin.dashboard') }}" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-[rgba(10,154,242,1)] hover:bg-blue-50">
                                    <div class="flex items-center">
                                        <svg class="mr-3 h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path>
                                        </svg>
                                        Dashboard Admin
                                    </div>
                                </a>
                            @else
                                <a href="{{ route('bookings.index') }}" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-[rgba(10,154,242,1)] hover:bg-blue-50">
                                    <div class="flex items-center">
                                        <svg class="mr-3 h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"></path>
                                        </svg>
                                        Pesanan Saya
                                    </div>
                                </a>
                            @endif

                            <a href="{{ route('settings.index') }}" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-[rgba(10,154,242,1)] hover:bg-blue-50">
                                <div class="flex items-center">
                                    <svg class="mr-3 h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                    Pengaturan
                                </div>
                            </a>

                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="w-full block px-3 py-2 rounded-md text-base font-medium text-red-600 hover:bg-red-50 text-left">
                                    <div class="flex items-center">
                                        <svg class="mr-3 h-5 w-5 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                        </svg>
                                        Keluar
                                    </div>
                                </button>
                            </form>
                        </div>
                    @endguest
                </div>
            </div>
        </div>
    </div>
</nav>

<script>
    // Mobile Menu Toggle
    document.getElementById('mobile-menu-btn').addEventListener('click', function() {
        var menu = document.getElementById('mobile-menu');
        menu.classList.toggle('hidden');
    });

    // User Profile Dropdown Toggle
    const userMenuBtn = document.getElementById('user-menu-button');
    const userMenuDropdown = document.getElementById('user-menu-dropdown');

    if (userMenuBtn && userMenuDropdown) {
        userMenuBtn.addEventListener('click', function(e) {
            e.stopPropagation();
            userMenuDropdown.classList.toggle('hidden');
            const isExpanded = userMenuDropdown.classList.contains('hidden') ? 'false' : 'true';
            userMenuBtn.setAttribute('aria-expanded', isExpanded);
        });

        // Close dropdown when clicking outside
        document.addEventListener('click', function(e) {
            if (!userMenuBtn.contains(e.target) && !userMenuDropdown.contains(e.target)) {
                userMenuDropdown.classList.add('hidden');
                userMenuBtn.setAttribute('aria-expanded', 'false');
            }
        });
    }
</script>
