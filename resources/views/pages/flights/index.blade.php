@extends('layouts.app')

@section('content')
<div class="bg-gray-50 min-h-screen py-12">
    <div class="container mx-auto px-4">
        {{-- Search Form --}}
        <div class="bg-white rounded-xl shadow-lg p-6 mb-8 -mt-24 relative z-10 border border-gray-100">
            <form action="{{ route('flights.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                {{-- From --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Dari</label>
                    <select name="from" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[rgba(10,154,242,0.5)]">
                        <option value="">Semua Bandara</option>
                        @foreach($airports as $airport)
                            <option value="{{ $airport->id }}" {{ request('from') == $airport->id ? 'selected' : '' }}>
                                {{ $airport->city }} ({{ $airport->code }})
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- To --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Ke</label>
                    <select name="to" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[rgba(10,154,242,0.5)]">
                        <option value="">Semua Bandara</option>
                        @foreach($airports as $airport)
                            <option value="{{ $airport->id }}" {{ request('to') == $airport->id ? 'selected' : '' }}>
                                {{ $airport->city }} ({{ $airport->code }})
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Date --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Pergi</label>
                    <input type="date" name="date" value="{{ request('date') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[rgba(10,154,242,0.5)]">
                </div>

                {{-- Submit --}}
                <div class="flex items-end">
                    <button type="submit" class="w-full px-6 py-2 bg-[rgba(10,154,242,1)] text-white rounded-lg font-semibold hover:bg-[rgba(10,154,242,0.9)] transition-all">
                        Cari Penerbangan
                    </button>
                </div>
            </form>
        </div>

        {{-- Results --}}
        <div class="space-y-6">
            <h2 class="text-2xl font-bold text-gray-900">Hasil Pencarian</h2>
            
            @forelse($flights as $flight)
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition-shadow">
                <div class="flex flex-col md:flex-row justify-between items-center gap-6">
                    {{-- Flight Info --}}
                    <div class="flex-1 w-full">
                        <div class="flex items-center gap-4 mb-4">
                            <div class="w-12 h-12 bg-blue-50 rounded-lg flex items-center justify-center text-2xl">
                                ✈️
                            </div>
                            <div>
                                <h3 class="font-bold text-gray-900">{{ $flight->airline }}</h3>
                                <p class="text-sm text-gray-500">{{ $flight->flight_code }} • {{ $flight->seat_class }}</p>
                            </div>
                        </div>
                        
                        <div class="flex items-center justify-between md:justify-start md:gap-12">
                            <div class="text-center md:text-left">
                                <div class="text-xl font-bold text-gray-900">{{ $flight->departure_time->format('H:i') }}</div>
                                <div class="text-sm text-gray-500">{{ $flight->fromAirport->code }}</div>
                            </div>
                            
                            <div class="flex flex-col items-center px-4">
                                <span class="text-xs text-gray-400 mb-1">Langsung</span>
                                <div class="w-24 h-px bg-gray-300 relative">
                                    <div class="absolute top-1/2 right-0 transform -translate-y-1/2">
                                        <svg class="w-4 h-4 text-gray-400" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M21 16v-2l-8-5V3.5c0-.83-.67-1.5-1.5-1.5S10 2.67 10 3.5V9l-8 5v2l8-2.5V19l-2 1.5V22l3.5-1 3.5 1v-1.5L13 19v-5.5l8 2.5z"/>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="text-center md:text-right">
                                <div class="text-xl font-bold text-gray-900">{{ $flight->arrival_time->format('H:i') }}</div>
                                <div class="text-sm text-gray-500">{{ $flight->toAirport->code }}</div>
                            </div>
                        </div>
                    </div>

                    {{-- Price & Action --}}
                    <div class="w-full md:w-auto text-center md:text-right border-t md:border-t-0 md:border-l border-gray-100 pt-4 md:pt-0 md:pl-6">
                        <p class="text-sm text-gray-500 mb-1">Harga per orang</p>
                        <div class="text-2xl font-bold text-[rgba(10,154,242,1)] mb-4">
                            Rp {{ number_format($flight->price, 0, ',', '.') }}
                        </div>
                        <a href="{{ route('flights.show', $flight) }}" class="inline-block w-full md:w-auto px-6 py-3 bg-[rgba(10,154,242,1)] text-white rounded-lg font-semibold hover:bg-[rgba(10,154,242,0.9)] transition-all">
                            Pilih Penerbangan
                        </a>
                    </div>
                </div>
            </div>
            @empty
            <div class="text-center py-12 bg-white rounded-xl border border-gray-100">
                <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                    </svg>
                </div>
                <h3 class="text-lg font-medium text-gray-900 mb-2">Penerbangan Tidak Ditemukan</h3>
                <p class="text-gray-500">Coba ubah filter pencarian Anda untuk menemukan penerbangan lain.</p>
            </div>
            @endforelse

            {{-- Pagination --}}
            @if($flights->hasPages())
                <div class="mt-8">
                    {{ $flights->withQueryString()->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
