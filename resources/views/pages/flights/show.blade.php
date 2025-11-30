@extends('layouts.app')

@section('content')
<div class="bg-gray-50 min-h-screen py-12">
    <div class="container mx-auto px-4">
        <div class="max-w-4xl mx-auto">
            {{-- Back Button --}}
            <a href="{{ url()->previous() }}" class="inline-flex items-center text-gray-600 hover:text-[rgba(10,154,242,1)] mb-6 transition-colors">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Kembali ke Pencarian
            </a>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                {{-- Left Column: Flight Details --}}
                <div class="md:col-span-2 space-y-6">
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                        <h2 class="text-xl font-bold text-gray-900 mb-6">Detail Penerbangan</h2>
                        
                        <div class="flex items-center gap-4 mb-6 pb-6 border-b border-gray-100">
                            <div class="w-16 h-16 bg-blue-50 rounded-xl flex items-center justify-center text-3xl">
                                ✈️
                            </div>
                            <div>
                                <h3 class="text-lg font-bold text-gray-900">{{ $flight->airline }}</h3>
                                <p class="text-gray-500">{{ $flight->flight_code }} • {{ $flight->seat_class }}</p>
                            </div>
                        </div>

                        <div class="space-y-8">
                            <div class="flex gap-4">
                                <div class="flex flex-col items-center">
                                    <div class="w-3 h-3 rounded-full bg-[rgba(10,154,242,1)]"></div>
                                    <div class="w-0.5 h-full bg-gray-200 my-2"></div>
                                    <div class="w-3 h-3 rounded-full border-2 border-[rgba(10,154,242,1)] bg-white"></div>
                                </div>
                                <div class="flex-1 space-y-8">
                                    <div>
                                        <div class="text-lg font-bold text-gray-900">{{ $flight->departure_time->format('H:i') }}</div>
                                        <div class="text-gray-600">{{ $flight->departure_time->format('d M Y') }}</div>
                                        <div class="font-medium text-gray-900">{{ $flight->fromAirport->name }} ({{ $flight->fromAirport->code }})</div>
                                        <div class="text-sm text-gray-500">{{ $flight->fromAirport->city }}</div>
                                    </div>
                                    <div>
                                        <div class="text-lg font-bold text-gray-900">{{ $flight->arrival_time->format('H:i') }}</div>
                                        <div class="text-gray-600">{{ $flight->arrival_time->format('d M Y') }}</div>
                                        <div class="font-medium text-gray-900">{{ $flight->toAirport->name }} ({{ $flight->toAirport->code }})</div>
                                        <div class="text-sm text-gray-500">{{ $flight->toAirport->city }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Booking Form --}}
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                        <h2 class="text-xl font-bold text-gray-900 mb-6">Data Pemesan</h2>
                        
                        @auth
                            <form action="{{ route('bookings.store') }}" method="POST" class="space-y-6">
                                @csrf
                                <input type="hidden" name="flight_id" value="{{ $flight->id }}">
                                
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap Penumpang</label>
                                    <input type="text" name="passenger_name" value="{{ old('passenger_name', auth()->user()->name) }}" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[rgba(10,154,242,0.5)]">
                                    <p class="text-xs text-gray-500 mt-1">Sesuai KTP/Paspor/SIM (tanpa gelar).</p>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Nomor WhatsApp</label>
                                    <input type="text" name="passenger_phone" value="{{ old('passenger_phone', auth()->user()->phone) }}" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[rgba(10,154,242,0.5)]">
                                    <p class="text-xs text-gray-500 mt-1">E-tiket dan notifikasi status akan dikirim ke nomor ini.</p>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Jumlah Kursi</label>
                                    <select name="seat_count" id="seat_count" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[rgba(10,154,242,0.5)]" onchange="updateTotal()">
                                        @for($i = 1; $i <= 5; $i++)
                                            <option value="{{ $i }}">{{ $i }} Penumpang</option>
                                        @endfor
                                    </select>
                                </div>

                                <button type="submit" class="w-full px-6 py-4 bg-[rgba(10,154,242,1)] text-white rounded-xl font-bold text-lg hover:bg-[rgba(10,154,242,0.9)] transition-all shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                                    Lanjutkan Pembayaran
                                </button>
                            </form>
                        @else
                            <div class="text-center py-8">
                                <p class="text-gray-600 mb-4">Silakan login terlebih dahulu untuk melakukan pemesanan.</p>
                                <a href="{{ route('login') }}" class="inline-block px-6 py-3 bg-[rgba(10,154,242,1)] text-white rounded-lg font-semibold hover:bg-[rgba(10,154,242,0.9)] transition-all">
                                    Masuk / Daftar
                                </a>
                            </div>
                        @endauth
                    </div>
                </div>

                {{-- Right Column: Price Summary --}}
                <div class="md:col-span-1">
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 sticky top-24">
                        <h3 class="font-bold text-gray-900 mb-4">Rincian Harga</h3>
                        
                        <div class="space-y-3 mb-6">
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">{{ $flight->airline }} (Dewasa)</span>
                                <span class="font-medium">Rp {{ number_format($flight->price, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">Jumlah</span>
                                <span class="font-medium" id="summary_count">x 1</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">Pajak</span>
                                <span class="font-medium text-green-600">Termasuk</span>
                            </div>
                        </div>

                        <div class="border-t border-gray-100 pt-4">
                            <div class="flex justify-between items-center mb-1">
                                <span class="font-bold text-gray-900">Total Pembayaran</span>
                            </div>
                            <div class="text-2xl font-bold text-[rgba(10,154,242,1)]" id="total_price">
                                Rp {{ number_format($flight->price, 0, ',', '.') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function updateTotal() {
        const price = {{ $flight->price }};
        const count = document.getElementById('seat_count').value;
        const total = price * count;
        
        document.getElementById('summary_count').textContent = 'x ' + count;
        document.getElementById('total_price').textContent = 'Rp ' + new Intl.NumberFormat('id-ID').format(total);
    }
</script>
@endsection
