@extends('layouts.admin')

@section('header', 'Manajemen Pesanan')

@section('content')
<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    {{-- Filters --}}
    <div class="px-6 py-4 border-b border-gray-100 bg-gray-50">
        <form action="{{ route('admin.bookings.index') }}" method="GET" class="flex flex-col md:flex-row gap-4">
            <div class="flex-1">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari kode booking atau nama penumpang..." class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
            </div>
            <div class="w-full md:w-48">
                <select name="status" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" onchange="this.form.submit()">
                    <option value="">Semua Status</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="confirmed" {{ request('status') == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                    <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                </select>
            </div>
            <div class="w-full md:w-48">
                <input type="date" name="date" value="{{ request('date') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" onchange="this.form.submit()">
            </div>
        </form>
    </div>
    
    <div class="overflow-x-auto">
        <table class="w-full text-left text-sm text-gray-600">
            <thead class="bg-white text-gray-900 font-medium border-b border-gray-100">
                <tr>
                    <th class="px-6 py-3">Kode Booking</th>
                    <th class="px-6 py-3">Penumpang</th>
                    <th class="px-6 py-3">Penerbangan</th>
                    <th class="px-6 py-3">Total Harga</th>
                    <th class="px-6 py-3">Status</th>
                    <th class="px-6 py-3">Tanggal</th>
                    <th class="px-6 py-3 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($bookings as $booking)
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-6 py-4 font-mono font-medium text-gray-900">{{ $booking->booking_code }}</td>
                    <td class="px-6 py-4">
                        <div class="font-medium text-gray-900">{{ $booking->passenger_name }}</div>
                        <div class="text-xs text-gray-500">{{ $booking->passenger_phone }}</div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="font-medium">{{ $booking->flight->flight_code }}</div>
                        <div class="text-xs text-gray-500">
                            {{ $booking->flight->fromAirport->code }} → {{ $booking->flight->toAirport->code }}
                        </div>
                    </td>
                    <td class="px-6 py-4 font-medium text-gray-900">
                        Rp {{ number_format($booking->total_price, 0, ',', '.') }}
                    </td>
                    <td class="px-6 py-4">
                        @if($booking->status == 'confirmed')
                            <span class="px-2 py-1 text-xs font-medium bg-green-100 text-green-700 rounded-full">Confirmed</span>
                        @elseif($booking->status == 'pending')
                            <span class="px-2 py-1 text-xs font-medium bg-yellow-100 text-yellow-700 rounded-full">Pending</span>
                        @else
                            <span class="px-2 py-1 text-xs font-medium bg-red-100 text-red-700 rounded-full">Cancelled</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-xs text-gray-500">
                        {{ $booking->created_at->format('d M Y H:i') }}
                    </td>
                    <td class="px-6 py-4 text-right">
                        <a href="{{ route('admin.bookings.show', $booking) }}" class="text-[rgba(10,154,242,1)] hover:underline font-medium">Detail</a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-6 py-8 text-center text-gray-500">Tidak ada data pesanan yang ditemukan.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($bookings->hasPages())
    <div class="px-6 py-4 border-t border-gray-100">
        {{ $bookings->links() }}
    </div>
    @endif
</div>
@endsection
