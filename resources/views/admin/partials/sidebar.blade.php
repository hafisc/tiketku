{{-- Admin Sidebar --}}
<aside id="sidebar" class="fixed inset-y-0 left-0 z-30 w-64 bg-[rgba(10,154,242,1)] text-white transition-transform duration-300 ease-in-out transform -translate-x-full md:translate-x-0 md:static md:inset-auto flex-shrink-0">
    <div class="p-6">
        <div class="flex items-center space-x-2 mb-8">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
            </svg>
            <span class="text-2xl font-bold">Tiketku</span>
        </div>

        <nav class="space-y-2">
            <a href="{{ route('admin.dashboard') }}" class="flex items-center px-4 py-3 rounded-lg {{ request()->routeIs('admin.dashboard') ? 'bg-white text-[rgba(10,154,242,1)]' : 'hover:bg-[rgba(10,154,242,0.8)]' }} transition-colors">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                </svg>
                Dashboard
            </a>

            <a href="{{ route('admin.airports.index') }}" class="flex items-center px-4 py-3 rounded-lg {{ request()->routeIs('admin.airports.*') ? 'bg-white text-[rgba(10,154,242,1)]' : 'hover:bg-[rgba(10,154,242,0.8)]' }} transition-colors">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                </svg>
                Bandara
            </a>

            <a href="{{ route('admin.flights.index') }}" class="flex items-center px-4 py-3 rounded-lg {{ request()->routeIs('admin.flights.*') ? 'bg-white text-[rgba(10,154,242,1)]' : 'hover:bg-[rgba(10,154,242,0.8)]' }} transition-colors">
                <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M21 16v-2l-8-5V3.5c0-.83-.67-1.5-1.5-1.5S10 2.67 10 3.5V9l-8 5v2l8-2.5V19l-2 1.5V22l3.5-1 3.5 1v-1.5L13 19v-5.5l8 2.5z"/>
                </svg>
                Penerbangan
            </a>

            <a href="{{ route('admin.bookings.index') }}" class="flex items-center px-4 py-3 rounded-lg {{ request()->routeIs('admin.bookings.*') ? 'bg-white text-[rgba(10,154,242,1)]' : 'hover:bg-[rgba(10,154,242,0.8)]' }} transition-colors">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                </svg>
                Pesanan
            </a>

            <div class="pt-4 mt-4 border-t border-white/20">
                <a href="/" class="flex items-center px-4 py-3 rounded-lg hover:bg-[rgba(10,154,242,0.8)] transition-colors">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Kembali ke Home
                </a>
            </div>
        </nav>
    </div>
</aside>
