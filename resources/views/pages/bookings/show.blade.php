@extends('layouts.app')

@section('content')
<div class="bg-gray-50 min-h-screen py-12">
    <div class="container mx-auto px-4">
        <div class="max-w-3xl mx-auto">
            {{-- Back Button --}}
            <a href="{{ route('bookings.index') }}" class="inline-flex items-center text-gray-600 hover:text-[rgba(10,154,242,1)] mb-6 transition-colors">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Kembali ke Pesanan Saya
            </a>

            {{-- Success Message --}}
            @if(session('success'))
                <div class="mb-6 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg flex items-center gap-3">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden">
                {{-- Header --}}
                <div class="bg-[rgba(10,154,242,1)] px-8 py-6 text-white flex justify-between items-center">
                    <div>
                        <p class="text-blue-100 text-sm mb-1">Kode Booking</p>
                        <h1 class="text-3xl font-mono font-bold">{{ $booking->booking_code }}</h1>
                    </div>
                    <div class="text-right">
                        <div class="inline-block px-3 py-1 rounded-full bg-white/20 backdrop-blur-sm text-sm font-medium">
                            {{ ucfirst($booking->status) }}
                        </div>
                    </div>
                </div>

                <div class="p-8 space-y-8">
                    {{-- Flight Info --}}
                    <div>
                        <h2 class="text-gray-500 text-sm font-medium uppercase tracking-wider mb-4">Detail Penerbangan</h2>
                        <div class="flex flex-col md:flex-row gap-8 items-center">
                            <div class="flex-1 w-full">
                                <div class="flex justify-between items-center mb-6">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 bg-blue-50 rounded-lg flex items-center justify-center text-xl">
                                            ✈️
                                        </div>
                                        <div>
                                            <h3 class="font-bold text-gray-900">{{ $booking->flight->airline }}</h3>
                                            <p class="text-sm text-gray-500">{{ $booking->flight->flight_code }} • {{ $booking->flight->seat_class }}</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="flex items-center justify-between">
                                    <div>
                                        <div class="text-2xl font-bold text-gray-900">{{ $booking->flight->departure_time->format('H:i') }}</div>
                                        <div class="text-sm text-gray-500">{{ $booking->flight->departure_time->format('d M Y') }}</div>
                                        <div class="font-medium text-[rgba(10,154,242,1)] mt-1">{{ $booking->flight->fromAirport->city }}</div>
                                    </div>
                                    
                                    <div class="flex-1 px-8 flex flex-col items-center">
                                        <div class="text-xs text-gray-400 mb-2">Langsung</div>
                                        <div class="w-full h-px bg-gray-300 relative">
                                            <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 bg-white px-2">
                                                <svg class="w-5 h-5 text-gray-400" fill="currentColor" viewBox="0 0 24 24">
                                                    <path d="M21 16v-2l-8-5V3.5c0-.83-.67-1.5-1.5-1.5S10 2.67 10 3.5V9l-8 5v2l8-2.5V19l-2 1.5V22l3.5-1 3.5 1v-1.5L13 19v-5.5l8 2.5z"/>
                                                </svg>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="text-right">
                                        <div class="text-2xl font-bold text-gray-900">{{ $booking->flight->arrival_time->format('H:i') }}</div>
                                        <div class="text-sm text-gray-500">{{ $booking->flight->arrival_time->format('d M Y') }}</div>
                                        <div class="font-medium text-[rgba(10,154,242,1)] mt-1">{{ $booking->flight->toAirport->city }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="h-px bg-gray-100"></div>

                    {{-- Passenger Info --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div>
                            <h2 class="text-gray-500 text-sm font-medium uppercase tracking-wider mb-4">Info Penumpang</h2>
                            <div class="space-y-3">
                                <div>
                                    <p class="text-xs text-gray-400">Nama Lengkap</p>
                                    <p class="font-medium text-gray-900">{{ $booking->passenger_name }}</p>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-400">Kontak (WhatsApp)</p>
                                    <p class="font-medium text-gray-900">{{ $booking->passenger_phone }}</p>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-400">Jumlah Kursi</p>
                                    <p class="font-medium text-gray-900">{{ $booking->seat_count }} Penumpang</p>
                                </div>
                            </div>
                        </div>

                        <div>
                            <h2 class="text-gray-500 text-sm font-medium uppercase tracking-wider mb-4">Rincian Pembayaran</h2>
                            <div class="space-y-3">
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Harga Tiket</span>
                                    <span class="font-medium">Rp {{ number_format($booking->flight->price, 0, ',', '.') }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Jumlah</span>
                                    <span class="font-medium">x {{ $booking->seat_count }}</span>
                                </div>
                                <div class="border-t border-dashed border-gray-200 pt-3 flex justify-between items-center">
                                    <span class="font-bold text-gray-900">Total</span>
                                    <span class="font-bold text-xl text-[rgba(10,154,242,1)]">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Action Buttons --}}
                    @if($booking->status == 'pending')
                    <div class="bg-yellow-50 border border-yellow-100 rounded-lg p-4 text-center">
                        <p class="text-yellow-800 text-sm mb-3">Pesanan Anda sedang menunggu konfirmasi. Silakan lakukan pembayaran sesuai instruksi (jika ada) atau hubungi admin.</p>
                        <a href="https://wa.me/6281234567890?text=Halo%20Admin,%20saya%20ingin%20konfirmasi%20pesanan%20{{ $booking->booking_code }}" target="_blank" class="inline-flex items-center px-4 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600 transition-colors text-sm font-medium">
                            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                            </svg>
                            Konfirmasi via WhatsApp
                        </a>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
