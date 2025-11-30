@extends('layouts.app')

@section('title', 'Tiketku - Pemesanan Tiket Pesawat Mudah & Cepat')

@section('content')

{{-- Hero Section --}}
<section class="relative bg-gradient-to-br from-[rgba(10,154,242,0.1)] via-blue-50 to-white overflow-hidden">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 lg:py-20">
        <div class="text-center space-y-6">
            <h1 class="text-4xl sm:text-5xl lg:text-6xl font-bold text-gray-900 leading-tight">
                Pesan Tiket Pesawat <span class="text-[rgba(10,154,242,1)]">Mudah & Cepat</span>
            </h1>
            <p class="text-lg sm:text-xl text-gray-600 max-w-3xl mx-auto">
                Temukan harga tiket termurah ke destinasi favorit Anda. Proses booking instan dengan notifikasi real-time via WhatsApp.
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="#search-form" class="px-8 py-4 bg-[rgba(10,154,242,1)] text-white rounded-xl font-semibold shadow-lg hover:shadow-xl hover:bg-[rgba(10,154,242,0.9)] transition-all transform hover:-translate-y-1">
                    Cari Tiket
                </a>
                <a href="#promo" class="px-8 py-4 border-2 border-[rgba(10,154,242,1)] text-[rgba(10,154,242,1)] rounded-xl font-semibold hover:bg-[rgba(10,154,242,0.1)] transition-all">
                    Lihat Promo
                </a>
            </div>
        </div>
    </div>
</section>

{{-- Search Form Section --}}
<section id="search-form" class="relative bg-white py-12 -mt-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="relative">
            <div class="bg-white rounded-2xl shadow-2xl p-6 sm:p-8 backdrop-blur-lg border border-gray-100">
                {{-- Tabs --}}
                <div class="flex gap-2 mb-6 bg-gray-100 rounded-lg p-1">
                    <button type="button" onclick="switchTripType('oneway')" id="tab-oneway" class="flex-1 px-4 py-2 bg-[rgba(10,154,242,1)] text-white rounded-lg font-medium text-sm transition-all">Sekali Jalan</button>
                    <button type="button" onclick="switchTripType('roundtrip')" id="tab-roundtrip" class="flex-1 px-4 py-2 text-gray-600 hover:text-[rgba(10,154,242,1)] rounded-lg font-medium text-sm transition-all">Pulang Pergi</button>
                    <button type="button" onclick="switchTripType('multicity')" id="tab-multicity" class="flex-1 px-4 py-2 text-gray-600 hover:text-[rgba(10,154,242,1)] rounded-lg font-medium text-sm transition-all">Multi-kota</button>
                </div>

                {{-- Form Fields --}}
                <form action="{{ route('flights.index') }}" method="GET" class="space-y-4">
                    <input type="hidden" name="trip_type" id="trip-type-input" value="oneway">
                    
                    {{-- Main Flight Search --}}
                    <div class="grid sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Dari</label>
                            <select name="from" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[rgba(10,154,242,0.5)] focus:border-[rgba(10,154,242,1)] transition-all">
                                <option value="">Pilih Bandara Asal</option>
                                @foreach($airports as $airport)
                                    <option value="{{ $airport->id }}">{{ $airport->city }} ({{ $airport->code }})</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Ke</label>
                            <select name="to" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[rgba(10,154,242,0.5)] focus:border-[rgba(10,154,242,1)] transition-all">
                                <option value="">Pilih Bandara Tujuan</option>
                                @foreach($airports as $airport)
                                    <option value="{{ $airport->id }}">{{ $airport->city }} ({{ $airport->code }})</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    
                    <div class="grid sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal Pergi</label>
                            <input type="date" name="date" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[rgba(10,154,242,0.5)] focus:border-[rgba(10,154,242,1)] transition-all">
                        </div>
                        <div id="return-date-field" class="hidden">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal Pulang</label>
                            <input type="date" name="return_date" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[rgba(10,154,242,0.5)] focus:border-[rgba(10,154,242,1)] transition-all">
                        </div>
                        <div id="class-field">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Kelas</label>
                            <select name="class" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[rgba(10,154,242,0.5)] focus:border-[rgba(10,154,242,1)] transition-all">
                                <option value="">Semua Kelas</option>
                                <option value="Economy">Economy</option>
                                <option value="Business">Business</option>
                                <option value="First Class">First Class</option>
                            </select>
                        </div>
                    </div>

                    {{-- Multi-city Additional Flights --}}
                    <div id="multicity-fields" class="hidden space-y-4">
                        <div class="border-t border-gray-200 pt-4">
                            <p class="text-sm font-medium text-gray-700 mb-4 flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                </svg>
                                Penerbangan Tambahan
                            </p>
                            <div class="grid sm:grid-cols-3 gap-4 mb-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Dari</label>
                                    <select name="from_2" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[rgba(10,154,242,0.5)] focus:border-[rgba(10,154,242,1)] transition-all">
                                        <option value="">Pilih Bandara</option>
                                        @foreach($airports as $airport)
                                            <option value="{{ $airport->id }}">{{ $airport->city }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Ke</label>
                                    <select name="to_2" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[rgba(10,154,242,0.5)] focus:border-[rgba(10,154,242,1)] transition-all">
                                        <option value="">Pilih Bandara</option>
                                        @foreach($airports as $airport)
                                            <option value="{{ $airport->id }}">{{ $airport->city }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal</label>
                                    <input type="date" name="date_2" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[rgba(10,154,242,0.5)] focus:border-[rgba(10,154,242,1)] transition-all">
                                </div>
                            </div>
                            <p class="text-xs text-gray-500 italic">* Multi-kota memerlukan pemesanan terpisah untuk setiap segmen</p>
                        </div>
                    </div>

                    <button type="submit" class="w-full px-6 py-4 bg-[rgba(10,154,242,1)] text-white rounded-xl font-semibold text-lg shadow-lg hover:shadow-xl hover:bg-[rgba(10,154,242,0.9)] transition-all transform hover:-translate-y-1">
                        Cari Tiket
                    </button>
                </form>
            </div>

            {{-- Floating Plane Animation --}}
            <div class="absolute -top-8 -right-8 hidden lg:block animate-bounce">
                <svg class="w-24 h-24 text-[rgba(10,154,242,0.3)]" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M21 16v-2l-8-5V3.5c0-.83-.67-1.5-1.5-1.5S10 2.67 10 3.5V9l-8 5v2l8-2.5V19l-2 1.5V22l3.5-1 3.5 1v-1.5L13 19v-5.5l8 2.5z"/>
                </svg>
            </div>
        </div>
    </div>

    <script>
        function switchTripType(type) {
            // Update hidden input
            document.getElementById('trip-type-input').value = type;
            
            // Update tab styles
            const tabs = ['oneway', 'roundtrip', 'multicity'];
            tabs.forEach(tab => {
                const btn = document.getElementById('tab-' + tab);
                if (tab === type) {
                    btn.className = 'flex-1 px-4 py-2 bg-[rgba(10,154,242,1)] text-white rounded-lg font-medium text-sm transition-all';
                } else {
                    btn.className = 'flex-1 px-4 py-2 text-gray-600 hover:text-[rgba(10,154,242,1)] rounded-lg font-medium text-sm transition-all';
                }
            });
            
            // Show/hide fields based on type
            const returnDateField = document.getElementById('return-date-field');
            const classField = document.getElementById('class-field');
            const multicityFields = document.getElementById('multicity-fields');
            
            if (type === 'roundtrip') {
                returnDateField.classList.remove('hidden');
                returnDateField.querySelector('input').required = true;
                classField.classList.remove('hidden');
                multicityFields.classList.add('hidden');
            } else if (type === 'multicity') {
                returnDateField.classList.add('hidden');
                returnDateField.querySelector('input').required = false;
                classField.classList.add('hidden');
                multicityFields.classList.remove('hidden');
            } else {
                returnDateField.classList.add('hidden');
                returnDateField.querySelector('input').required = false;
                classField.classList.remove('hidden');
                multicityFields.classList.add('hidden');
            }
        }
    </script>
</section>

{{-- Section Keunggulan --}}
<section class="py-16 lg:py-24 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl sm:text-4xl font-bold text-gray-900 mb-4">Kenapa Memilih Tiketku?</h2>
            <p class="text-lg text-gray-600">Pengalaman booking tiket terbaik dengan berbagai keunggulan</p>
        </div>
        <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-8">
            {{-- Card 1 --}}
            <div class="bg-white rounded-xl p-6 border border-gray-200 hover:border-[rgba(10,154,242,1)] hover:-translate-y-2 hover:shadow-xl transition-all duration-300">
                <div class="w-16 h-16 bg-[rgba(10,154,242,0.1)] rounded-full flex items-center justify-center mb-4">
                    <svg class="w-8 h-8 text-[rgba(10,154,242,1)]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">Harga Terbaik</h3>
                <p class="text-gray-600">Dapatkan tiket dengan harga termurah dari berbagai maskapai</p>
            </div>

            {{-- Card 2 --}}
            <div class="bg-white rounded-xl p-6 border border-gray-200 hover:border-[rgba(10,154,242,1)] hover:-translate-y-2 hover:shadow-xl transition-all duration-300">
                <div class="w-16 h-16 bg-[rgba(10,154,242,0.1)] rounded-full flex items-center justify-center mb-4">
                    <svg class="w-8 h-8 text-[rgba(10,154,242,1)]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">Proses Cepat</h3>
                <p class="text-gray-600">Booking dalam hitungan menit, e-ticket langsung terkirim</p>
            </div>

            {{-- Card 3 --}}
            <div class="bg-white rounded-xl p-6 border border-gray-200 hover:border-[rgba(10,154,242,1)] hover:-translate-y-2 hover:shadow-xl transition-all duration-300">
                <div class="w-16 h-16 bg-[rgba(10,154,242,0.1)] rounded-full flex items-center justify-center mb-4">
                    <svg class="w-8 h-8 text-[rgba(10,154,242,1)]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">Customer Support 24/7</h3>
                <p class="text-gray-600">Tim support siap membantu kapan saja Anda membutuhkan</p>
            </div>

            {{-- Card 4 --}}
            <div class="bg-white rounded-xl p-6 border border-gray-200 hover:border-[rgba(10,154,242,1)] hover:-translate-y-2 hover:shadow-xl transition-all duration-300">
                <div class="w-16 h-16 bg-[rgba(10,154,242,0.1)] rounded-full flex items-center justify-center mb-4">
                    <svg class="w-8 h-8 text-[rgba(10,154,242,1)]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">Notifikasi WhatsApp</h3>
                <p class="text-gray-600">Update status penerbangan langsung ke WhatsApp Anda</p>
            </div>
        </div>
    </div>
</section>

{{-- Section Promo & Rute Populer --}}
<section id="promo" class="py-16 lg:py-24 bg-gradient-to-br from-blue-50 to-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        {{-- Promo Spesial --}}
        <div class="mb-16">
            <h2 class="text-3xl sm:text-4xl font-bold text-gray-900 mb-8">Promo Spesial</h2>
            <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
                <div class="bg-gradient-to-br from-[rgba(10,154,242,1)] to-blue-600 rounded-2xl p-6 text-white hover:shadow-2xl transition-all transform hover:-translate-y-2">
                    <div class="flex justify-between items-start mb-4">
                        <div>
                            <p class="text-sm opacity-90">Jakarta → Singapore</p>
                            <h3 class="text-2xl font-bold mt-1">Diskon 20%</h3>
                        </div>
                        <span class="bg-white text-[rgba(10,154,242,1)] px-3 py-1 rounded-full text-xs font-bold">PROMO</span>
                    </div>
                    <p class="text-3xl font-bold mb-4">Rp 899.000</p>
                    <button class="w-full bg-white text-[rgba(10,154,242,1)] py-3 rounded-lg font-semibold hover:bg-gray-100 transition-all">Lihat Detail</button>
                </div>

                <div class="bg-gradient-to-br from-purple-500 to-pink-500 rounded-2xl p-6 text-white hover:shadow-2xl transition-all transform hover:-translate-y-2">
                    <div class="flex justify-between items-start mb-4">
                        <div>
                            <p class="text-sm opacity-90">Jakarta → Bali</p>
                            <h3 class="text-2xl font-bold mt-1">Flash Sale</h3>
                        </div>
                        <span class="bg-white text-purple-600 px-3 py-1 rounded-full text-xs font-bold">HOT</span>
                    </div>
                    <p class="text-3xl font-bold mb-4">Rp 499.000</p>
                    <button class="w-full bg-white text-purple-600 py-3 rounded-lg font-semibold hover:bg-gray-100 transition-all">Lihat Detail</button>
                </div>

                <div class="bg-gradient-to-br from-orange-500 to-red-500 rounded-2xl p-6 text-white hover:shadow-2xl transition-all transform hover:-translate-y-2">
                    <div class="flex justify-between items-start mb-4">
                        <div>
                            <p class="text-sm opacity-90">Surabaya → Bangkok</p>
                            <h3 class="text-2xl font-bold mt-1">Super Hemat</h3>
                        </div>
                        <span class="bg-white text-orange-600 px-3 py-1 rounded-full text-xs font-bold">NEW</span>
                    </div>
                    <p class="text-3xl font-bold mb-4">Rp 1.299.000</p>
                    <button class="w-full bg-white text-orange-600 py-3 rounded-lg font-semibold hover:bg-gray-100 transition-all">Lihat Detail</button>
                </div>
            </div>
        </div>

        {{-- Rute Populer --}}
        <div id="rute">
            <h2 class="text-3xl sm:text-4xl font-bold text-gray-900 mb-8">Rute Populer</h2>
            <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-4">
                <div class="bg-white rounded-xl p-5 border border-gray-200 hover:border-[rgba(10,154,242,1)] hover:shadow-lg transition-all">
                    <p class="font-semibold text-gray-900 text-lg mb-2">Jakarta → Singapore</p>
                    <p class="text-sm text-gray-600 mb-3">Mulai dari <span class="font-bold text-[rgba(10,154,242,1)]">Rp 899K</span></p>
                    <p class="text-xs text-gray-500">20+ penerbangan/hari</p>
                </div>
                <div class="bg-white rounded-xl p-5 border border-gray-200 hover:border-[rgba(10,154,242,1)] hover:shadow-lg transition-all">
                    <p class="font-semibold text-gray-900 text-lg mb-2">Jakarta → Kuala Lumpur</p>
                    <p class="text-sm text-gray-600 mb-3">Mulai dari <span class="font-bold text-[rgba(10,154,242,1)]">Rp 799K</span></p>
                    <p class="text-xs text-gray-500">15+ penerbangan/hari</p>
                </div>
                <div class="bg-white rounded-xl p-5 border border-gray-200 hover:border-[rgba(10,154,242,1)] hover:shadow-lg transition-all">
                    <p class="font-semibold text-gray-900 text-lg mb-2">Bali → Sydney</p>
                    <p class="text-sm text-gray-600 mb-3">Mulai dari <span class="font-bold text-[rgba(10,154,242,1)]">Rp 2.5JT</span></p>
                    <p class="text-xs text-gray-500">5+ penerbangan/hari</p>
                </div>
                <div class="bg-white rounded-xl p-5 border border-gray-200 hover:border-[rgba(10,154,242,1)] hover:shadow-lg transition-all">
                    <p class="font-semibold text-gray-900 text-lg mb-2">Surabaya → Bangkok</p>
                    <p class="text-sm text-gray-600 mb-3">Mulai dari <span class="font-bold text-[rgba(10,154,242,1)]">Rp 1.2JT</span></p>
                    <p class="text-xs text-gray-500">8+ penerbangan/hari</p>
                </div>
            </div>
        </div>
    </div>
</section>



{{-- Section Testimoni --}}
<section class="py-16 lg:py-24 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl sm:text-4xl font-bold text-gray-900 mb-4">Apa Kata Pengguna?</h2>
            <p class="text-lg text-gray-600">Testimoni dari pelanggan setia Tiketku</p>
        </div>
        <div class="grid md:grid-cols-3 gap-8">
            <div class="bg-white rounded-2xl p-6 border border-gray-200 hover:shadow-xl transition-all hover:-translate-y-1">
                <div class="flex items-center mb-4">
                    <div class="w-12 h-12 rounded-full bg-gradient-to-br from-[rgba(10,154,242,1)] to-blue-400 flex items-center justify-center text-white font-bold text-lg">
                        A
                    </div>
                    <div class="ml-3">
                        <p class="font-semibold text-gray-900">Ahmad Rizki</p>
                        <p class="text-sm text-gray-600">Jakarta</p>
                    </div>
                </div>
                <p class="text-gray-600 italic">"Proses booking sangat cepat dan mudah. Harga juga lebih murah dibanding platform lain. Recommended!"</p>
            </div>

            <div class="bg-white rounded-2xl p-6 border border-gray-200 hover:shadow-xl transition-all hover:-translate-y-1 md:mt-6">
                <div class="flex items-center mb-4">
                    <div class="w-12 h-12 rounded-full bg-gradient-to-br from-purple-500 to-pink-500 flex items-center justify-center text-white font-bold text-lg">
                        S
                    </div>
                    <div class="ml-3">
                        <p class="font-semibold text-gray-900">Siti Nurhaliza</p>
                        <p class="text-sm text-gray-600">Surabaya</p>
                    </div>
                </div>
                <p class="text-gray-600 italic">"Notifikasi via WhatsApp sangat membantu. Saya selalu update dengan status penerbangan. Top!"</p>
            </div>

            <div class="bg-white rounded-2xl p-6 border border-gray-200 hover:shadow-xl transition-all hover:-translate-y-1">
                <div class="flex items-center mb-4">
                    <div class="w-12 h-12 rounded-full bg-gradient-to-br from-orange-500 to-red-500 flex items-center justify-center text-white font-bold text-lg">
                        B
                    </div>
                    <div class="ml-3">
                        <p class="font-semibold text-gray-900">Budi Santoso</p>
                        <p class="text-sm text-gray-600">Bali</p>
                    </div>
                </div>
                <p class="text-gray-600 italic">"Customer service responsif banget. Ada masalah langsung dibantu sampai selesai. Puas!"</p>
            </div>
        </div>
    </div>
</section>

{{-- Section CTA Akhir --}}
<section id="bantuan" class="py-16 lg:py-24 bg-gradient-to-br from-[rgba(10,154,242,1)] to-blue-700 text-white">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="text-3xl sm:text-4xl lg:text-5xl font-bold mb-6">Siap Terbang ke Destinasi Impianmu?</h2>
        <p class="text-lg sm:text-xl mb-8 opacity-90">Pesan tiket sekarang dan nikmati berbagai promo menarik. Dapatkan harga terbaik dengan layanan terpercaya!</p>
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="#search-form" class="px-8 py-4 bg-white text-[rgba(10,154,242,1)] rounded-xl font-semibold shadow-lg hover:shadow-xl hover:bg-gray-100 transition-all transform hover:-translate-y-1">
                Mulai Pesan Sekarang
            </a>
            <a href="https://wa.me/6281234567890" class="px-8 py-4 border-2 border-white text-white rounded-xl font-semibold hover:bg-white hover:text-[rgba(10,154,242,1)] transition-all flex items-center justify-center gap-2">
                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                </svg>
                Hubungi via WhatsApp
            </a>
        </div>
    </div>
</section>

@endsection
