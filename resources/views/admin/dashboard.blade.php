@extends('layouts.admin')

@section('header', 'Dashboard Overview')

@section('content')
<div class="space-y-6">
    {{-- Stats Grid --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        {{-- Total Flights --}}
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-gray-500 text-sm font-medium">Total Penerbangan</h3>
                <div class="p-2 bg-blue-50 rounded-lg">
                    <svg class="w-6 h-6 text-blue-600" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M21 16v-2l-8-5V3.5c0-.83-.67-1.5-1.5-1.5S10 2.67 10 3.5V9l-8 5v2l8-2.5V19l-2 1.5V22l3.5-1 3.5 1v-1.5L13 19v-5.5l8 2.5z"/>
                    </svg>
                </div>
            </div>
            <div class="flex items-baseline">
                <span class="text-2xl font-bold text-gray-900">{{ $stats['total_flights'] }}</span>
                <span class="ml-2 text-sm text-green-600">{{ $stats['active_flights'] }} aktif</span>
            </div>
        </div>

        {{-- Total Bookings --}}
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-gray-500 text-sm font-medium">Total Pesanan</h3>
                <div class="p-2 bg-purple-50 rounded-lg">
                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                    </svg>
                </div>
            </div>
            <div class="flex items-baseline">
                <span class="text-2xl font-bold text-gray-900">{{ $stats['total_bookings'] }}</span>
                <span class="ml-2 text-sm text-gray-500">All time</span>
            </div>
        </div>

        {{-- Pending Bookings --}}
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-gray-500 text-sm font-medium">Menunggu Konfirmasi</h3>
                <div class="p-2 bg-yellow-50 rounded-lg">
                    <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
            <div class="flex items-baseline">
                <span class="text-2xl font-bold text-gray-900">{{ $stats['pending_bookings'] }}</span>
                <span class="ml-2 text-sm text-yellow-600">Perlu tindakan</span>
            </div>
        </div>

        {{-- Total Users --}}
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-gray-500 text-sm font-medium">Total User</h3>
                <div class="p-2 bg-green-50 rounded-lg">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                    </svg>
                </div>
            </div>
            <div class="flex items-baseline">
                <span class="text-2xl font-bold text-gray-900">{{ $stats['total_users'] }}</span>
                <span class="ml-2 text-sm text-gray-500">Terdaftar</span>
            </div>
        </div>
    </div>

    {{-- Recent Bookings --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center">
            <h2 class="text-lg font-semibold text-gray-900">Pesanan Terbaru</h2>
            <a href="{{ route('admin.bookings.index') }}" class="text-sm text-[rgba(10,154,242,1)] hover:underline">Lihat Semua</a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-gray-600">
                <thead class="bg-gray-50 text-gray-900 font-medium border-b border-gray-100">
                    <tr>
                        <th class="px-6 py-3">Kode Booking</th>
                        <th class="px-6 py-3">Penumpang</th>
                        <th class="px-6 py-3">Rute</th>
                        <th class="px-6 py-3">Tanggal</th>
                        <th class="px-6 py-3">Status</th>
                        <th class="px-6 py-3">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($recent_bookings as $booking)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4 font-medium text-gray-900">{{ $booking->booking_code }}</td>
                        <td class="px-6 py-4">
                            <div class="font-medium text-gray-900">{{ $booking->passenger_name }}</div>
                            <div class="text-xs text-gray-500">{{ $booking->passenger_phone }}</div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-2">
                                <span class="font-medium">{{ $booking->flight->fromAirport->code }}</span>
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                                </svg>
                                <span class="font-medium">{{ $booking->flight->toAirport->code }}</span>
                            </div>
                            <div class="text-xs text-gray-500">{{ $booking->flight->airline }}</div>
                        </td>
                        <td class="px-6 py-4">{{ $booking->created_at->format('d M Y H:i') }}</td>
                        <td class="px-6 py-4">
                            @if($booking->status == 'confirmed')
                                <span class="px-2 py-1 text-xs font-medium bg-green-100 text-green-700 rounded-full">Confirmed</span>
                            @elseif($booking->status == 'pending')
                                <span class="px-2 py-1 text-xs font-medium bg-yellow-100 text-yellow-700 rounded-full">Pending</span>
                            @else
                                <span class="px-2 py-1 text-xs font-medium bg-red-100 text-red-700 rounded-full">Cancelled</span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <a href="{{ route('admin.bookings.show', $booking) }}" class="text-[rgba(10,154,242,1)] hover:underline">Detail</a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-8 text-center text-gray-500">Belum ada pesanan terbaru.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
