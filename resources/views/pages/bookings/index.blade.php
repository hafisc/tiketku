@extends('layouts.app')

@section('content')
<div class="bg-gray-50 min-h-screen py-12">
    <div class="container mx-auto px-4">
        <div class="max-w-5xl mx-auto">
            <h1 class="text-2xl font-bold text-gray-900 mb-8">Pesanan Saya</h1>

            @if(session('success'))
                <div class="mb-6 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg flex items-center gap-3">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    {{ session('success') }}
                </div>
            @endif

            <div class="space-y-6">
                @forelse($bookings as $booking)
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition-shadow">
                    <div class="p-6">
                        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-6">
                            <div>
                                <div class="flex items-center gap-3 mb-1">
                                    <span class="font-mono font-bold text-gray-900">{{ $booking->booking_code }}</span>
                                    @if($booking->status == 'confirmed')
                                        <span class="px-2 py-0.5 text-xs font-medium bg-green-100 text-green-700 rounded-full">Confirmed</span>
                                    @elseif($booking->status == 'pending')
                                        <span class="px-2 py-0.5 text-xs font-medium bg-yellow-100 text-yellow-700 rounded-full">Pending</span>
                                    @else
                                        <span class="px-2 py-0.5 text-xs font-medium bg-red-100 text-red-700 rounded-full">Cancelled</span>
                                    @endif
                                </div>
                                <p class="text-sm text-gray-500">Dipesan pada {{ $booking->created_at->format('d M Y, H:i') }}</p>
                            </div>
                            <div class="text-right">
                                <p class="text-sm text-gray-500">Total Pembayaran</p>
                                <p class="text-xl font-bold text-[rgba(10,154,242,1)]">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</p>
                            </div>
                        </div>

                        <div class="border-t border-gray-100 pt-6 flex flex-col md:flex-row gap-8">
                            <div class="flex-1">
                                <div class="flex items-center gap-4 mb-4">
                                    <div class="w-10 h-10 bg-blue-50 rounded-lg flex items-center justify-center text-xl">
                                        ✈️
                                    </div>
                                    <div>
                                        <h3 class="font-bold text-gray-900">{{ $booking->flight->airline }}</h3>
                                        <p class="text-sm text-gray-500">{{ $booking->flight->flight_code }} • {{ $booking->flight->seat_class }}</p>
                                    </div>
                                </div>
                                
                                <div class="flex items-center gap-8">
                                    <div>
                                        <div class="font-bold text-gray-900">{{ $booking->flight->departure_time->format('H:i') }}</div>
                                        <div class="text-sm text-gray-500">{{ $booking->flight->fromAirport->city }} ({{ $booking->flight->fromAirport->code }})</div>
                                    </div>
                                    <div class="flex-1 h-px bg-gray-300 relative min-w-[50px]">
                                        <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 bg-white px-2">
                                            <svg class="w-4 h-4 text-gray-400" fill="currentColor" viewBox="0 0 24 24">
                                                <path d="M21 16v-2l-8-5V3.5c0-.83-.67-1.5-1.5-1.5S10 2.67 10 3.5V9l-8 5v2l8-2.5V19l-2 1.5V22l3.5-1 3.5 1v-1.5L13 19v-5.5l8 2.5z"/>
                                            </svg>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <div class="font-bold text-gray-900">{{ $booking->flight->arrival_time->format('H:i') }}</div>
                                        <div class="text-sm text-gray-500">{{ $booking->flight->toAirport->city }} ({{ $booking->flight->toAirport->code }})</div>
                                    </div>
                                </div>
                            </div>

                            <div class="flex items-end">
                                <a href="{{ route('bookings.show', $booking) }}" class="w-full md:w-auto px-6 py-2 border-2 border-[rgba(10,154,242,1)] text-[rgba(10,154,242,1)] rounded-lg font-semibold hover:bg-[rgba(10,154,242,0.05)] transition-all text-center">
                                    Lihat Detail
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                <div class="text-center py-16 bg-white rounded-xl border border-gray-100">
                    <div class="w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-6">
                        <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Belum Ada Pesanan</h3>
                    <p class="text-gray-500 mb-8">Anda belum melakukan pemesanan tiket pesawat apapun.</p>
                    <a href="{{ route('home') }}" class="px-8 py-3 bg-[rgba(10,154,242,1)] text-white rounded-lg font-semibold hover:bg-[rgba(10,154,242,0.9)] transition-all shadow-lg">
                        Cari Tiket Sekarang
                    </a>
                </div>
                @endforelse

                @if($bookings->hasPages())
                    <div class="mt-8">
                        {{ $bookings->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
