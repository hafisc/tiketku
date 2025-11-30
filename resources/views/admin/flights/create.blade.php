@extends('layouts.admin')

@section('header', 'Tambah Penerbangan')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100">
            <h2 class="text-lg font-semibold text-gray-900">Form Penerbangan Baru</h2>
        </div>
        
        <form action="{{ route('admin.flights.store') }}" method="POST" class="p-6 space-y-6">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- Flight Code --}}
                <div>
                    <label for="flight_code" class="block text-sm font-medium text-gray-700 mb-1">Kode Penerbangan</label>
                    <input type="text" name="flight_code" id="flight_code" value="{{ old('flight_code') }}" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 uppercase" placeholder="GA-123">
                    @error('flight_code')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Airline --}}
                <div>
                    <label for="airline" class="block text-sm font-medium text-gray-700 mb-1">Maskapai</label>
                    <input type="text" name="airline" id="airline" value="{{ old('airline') }}" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="Garuda Indonesia">
                    @error('airline')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- From Airport --}}
                <div>
                    <label for="from_airport_id" class="block text-sm font-medium text-gray-700 mb-1">Dari Bandara</label>
                    <select name="from_airport_id" id="from_airport_id" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Pilih Bandara Asal</option>
                        @foreach($airports as $airport)
                            <option value="{{ $airport->id }}" {{ old('from_airport_id') == $airport->id ? 'selected' : '' }}>
                                {{ $airport->city }} ({{ $airport->code }}) - {{ $airport->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('from_airport_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- To Airport --}}
                <div>
                    <label for="to_airport_id" class="block text-sm font-medium text-gray-700 mb-1">Ke Bandara</label>
                    <select name="to_airport_id" id="to_airport_id" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Pilih Bandara Tujuan</option>
                        @foreach($airports as $airport)
                            <option value="{{ $airport->id }}" {{ old('to_airport_id') == $airport->id ? 'selected' : '' }}>
                                {{ $airport->city }} ({{ $airport->code }}) - {{ $airport->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('to_airport_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Departure Time --}}
                <div>
                    <label for="departure_time" class="block text-sm font-medium text-gray-700 mb-1">Waktu Keberangkatan</label>
                    <input type="datetime-local" name="departure_time" id="departure_time" value="{{ old('departure_time') }}" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    @error('departure_time')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Arrival Time --}}
                <div>
                    <label for="arrival_time" class="block text-sm font-medium text-gray-700 mb-1">Waktu Kedatangan</label>
                    <input type="datetime-local" name="arrival_time" id="arrival_time" value="{{ old('arrival_time') }}" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    @error('arrival_time')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Price --}}
                <div>
                    <label for="price" class="block text-sm font-medium text-gray-700 mb-1">Harga Tiket (IDR)</label>
                    <input type="number" name="price" id="price" value="{{ old('price') }}" required min="0" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="1000000">
                    @error('price')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Seat Class --}}
                <div>
                    <label for="seat_class" class="block text-sm font-medium text-gray-700 mb-1">Kelas Kursi</label>
                    <select name="seat_class" id="seat_class" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="Economy" {{ old('seat_class') == 'Economy' ? 'selected' : '' }}>Economy</option>
                        <option value="Business" {{ old('seat_class') == 'Business' ? 'selected' : '' }}>Business</option>
                        <option value="First Class" {{ old('seat_class') == 'First Class' ? 'selected' : '' }}>First Class</option>
                    </select>
                    @error('seat_class')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Status --}}
                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                    <select name="status" id="status" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                    @error('status')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="flex justify-end gap-3 pt-4">
                <a href="{{ route('admin.flights.index') }}" class="px-4 py-2 text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 transition-colors">Batal</a>
                <button type="submit" class="px-4 py-2 bg-[rgba(10,154,242,1)] text-white rounded-lg hover:bg-[rgba(10,154,242,0.9)] transition-colors">Simpan Penerbangan</button>
            </div>
        </form>
    </div>
</div>
@endsection
