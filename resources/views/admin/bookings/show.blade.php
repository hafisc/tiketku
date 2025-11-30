@extends('layouts.admin')

@section('header', 'Detail Pesanan')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    {{-- Header & Status --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">{{ $booking->booking_code }}</h2>
            <p class="text-gray-500 text-sm">Dibuat pada {{ $booking->created_at->format('d F Y, H:i') }}</p>
        </div>
        <div class="flex items-center gap-3">
            <span class="text-sm font-medium text-gray-600">Status Saat Ini:</span>
            @if($booking->status == 'confirmed')
                <span class="px-3 py-1 text-sm font-medium bg-green-100 text-green-700 rounded-full">Confirmed</span>
            @elseif($booking->status == 'pending')
                <span class="px-3 py-1 text-sm font-medium bg-yellow-100 text-yellow-700 rounded-full">Pending</span>
            @else
                <span class="px-3 py-1 text-sm font-medium bg-red-100 text-red-700 rounded-full">Cancelled</span>
            @endif
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        {{-- Left Column: Details --}}
        <div class="md:col-span-2 space-y-6">
            {{-- Flight Info --}}
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h3 class="font-semibold text-gray-900 mb-4 border-b border-gray-100 pb-2">Informasi Penerbangan</h3>
                <div class="space-y-4">
                    <div class="flex justify-between">
                        <div>
                            <p class="text-sm text-gray-500">Maskapai</p>
                            <p class="font-medium text-gray-900">{{ $booking->flight->airline }}</p>
                        </div>
                        <div class="text-right">
                            <p class="text-sm text-gray-500">Kode Penerbangan</p>
                            <p class="font-mono font-medium text-gray-900">{{ $booking->flight->flight_code }}</p>
                        </div>
                    </div>
                    
                    <div class="flex items-center justify-between bg-gray-50 p-4 rounded-lg">
                        <div class="text-center">
                            <div class="text-2xl font-bold text-[rgba(10,154,242,1)]">{{ $booking->flight->fromAirport->code }}</div>
                            <div class="text-sm text-gray-600">{{ $booking->flight->fromAirport->city }}</div>
                            <div class="text-xs text-gray-500">{{ $booking->flight->departure_time->format('H:i') }}</div>
                        </div>
                        <div class="flex-1 px-4 flex flex-col items-center">
                            <div class="text-xs text-gray-400 mb-1">{{ $booking->flight->departure_time->format('d M Y') }}</div>
                            <div class="w-full h-px bg-gray-300 relative">
                                <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 bg-gray-50 px-2">
                                    <svg class="w-4 h-4 text-gray-400" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M21 16v-2l-8-5V3.5c0-.83-.67-1.5-1.5-1.5S10 2.67 10 3.5V9l-8 5v2l8-2.5V19l-2 1.5V22l3.5-1 3.5 1v-1.5L13 19v-5.5l8 2.5z"/>
                                    </svg>
                                </div>
                            </div>
                        </div>
                        <div class="text-center">
                            <div class="text-2xl font-bold text-[rgba(10,154,242,1)]">{{ $booking->flight->toAirport->code }}</div>
                            <div class="text-sm text-gray-600">{{ $booking->flight->toAirport->city }}</div>
                            <div class="text-xs text-gray-500">{{ $booking->flight->arrival_time->format('H:i') }}</div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Passenger Info --}}
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h3 class="font-semibold text-gray-900 mb-4 border-b border-gray-100 pb-2">Informasi Penumpang</h3>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <p class="text-sm text-gray-500">Nama Penumpang</p>
                        <p class="font-medium text-gray-900">{{ $booking->passenger_name }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Nomor Telepon (WhatsApp)</p>
                        <p class="font-medium text-gray-900">{{ $booking->passenger_phone }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Jumlah Kursi</p>
                        <p class="font-medium text-gray-900">{{ $booking->seat_count }} Kursi</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Kelas</p>
                        <p class="font-medium text-gray-900">{{ $booking->flight->seat_class }}</p>
                    </div>
                </div>
            </div>
            
            {{-- Notification Logs --}}
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h3 class="font-semibold text-gray-900 mb-4 border-b border-gray-100 pb-2">Log Notifikasi WhatsApp</h3>
                <div class="space-y-4">
                    @forelse($booking->notifications as $notif)
                        <div class="flex items-start gap-3 text-sm">
                            <div class="mt-0.5">
                                @if($notif->status == 'sent')
                                    <span class="text-green-500">●</span>
                                @elseif($notif->status == 'failed')
                                    <span class="text-red-500">●</span>
                                @else
                                    <span class="text-yellow-500">●</span>
                                @endif
                            </div>
                            <div class="flex-1">
                                <div class="flex justify-between">
                                    <span class="font-medium text-gray-900">{{ ucfirst($notif->status) }}</span>
                                    <span class="text-gray-500 text-xs">{{ $notif->created_at->format('d M Y H:i:s') }}</span>
                                </div>
                                <p class="text-gray-600 mt-1">{{ $notif->message }}</p>
                                @if($notif->response_payload)
                                    <details class="mt-1">
                                        <summary class="text-xs text-blue-500 cursor-pointer">Lihat Response API</summary>
                                        <pre class="text-xs bg-gray-50 p-2 rounded mt-1 overflow-x-auto">{{ $notif->response_payload }}</pre>
                                    </details>
                                @endif
                            </div>
                        </div>
                    @empty
                        <p class="text-gray-500 text-sm">Belum ada notifikasi yang dikirim.</p>
                    @endforelse
                </div>
            </div>
        </div>

        {{-- Right Column: Actions --}}
        <div class="space-y-6">
            {{-- Payment Info --}}
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h3 class="font-semibold text-gray-900 mb-4 border-b border-gray-100 pb-2">Rincian Pembayaran</h3>
                <div class="space-y-2 mb-4">
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-600">Harga per kursi</span>
                        <span class="font-medium">Rp {{ number_format($booking->flight->price, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-600">Jumlah kursi</span>
                        <span class="font-medium">x {{ $booking->seat_count }}</span>
                    </div>
                    <div class="border-t border-gray-100 pt-2 flex justify-between items-center">
                        <span class="font-bold text-gray-900">Total</span>
                        <span class="font-bold text-xl text-[rgba(10,154,242,1)]">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>

            {{-- Update Status --}}
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h3 class="font-semibold text-gray-900 mb-4 border-b border-gray-100 pb-2">Update Status</h3>
                <form action="{{ route('admin.bookings.updateStatus', $booking) }}" method="POST" class="space-y-4">
                    @csrf
                    @method('PATCH')
                    
                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status Pesanan</label>
                        <select name="status" id="status" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <option value="pending" {{ $booking->status == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="confirmed" {{ $booking->status == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                            <option value="cancelled" {{ $booking->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                        </select>
                    </div>

                    <div>
                        <label for="notes" class="block text-sm font-medium text-gray-700 mb-1">Catatan (Opsional)</label>
                        <textarea name="notes" id="notes" rows="3" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">{{ $booking->notes }}</textarea>
                    </div>

                    <button type="submit" class="w-full px-4 py-2 bg-[rgba(10,154,242,1)] text-white rounded-lg hover:bg-[rgba(10,154,242,0.9)] transition-colors font-medium">
                        Update Status & Kirim Notifikasi
                    </button>
                    <p class="text-xs text-gray-500 text-center mt-2">
                        Mengubah status akan otomatis mengirim pesan WhatsApp ke penumpang.
                    </p>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
