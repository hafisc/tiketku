@extends('layouts.admin')

@section('header', 'Manajemen Penerbangan')

@section('content')
<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center">
        <h2 class="text-lg font-semibold text-gray-900">Daftar Penerbangan</h2>
        <a href="{{ route('admin.flights.create') }}" class="px-4 py-2 bg-[rgba(10,154,242,1)] text-white rounded-lg hover:bg-[rgba(10,154,242,0.9)] transition-colors text-sm font-medium">
            + Tambah Penerbangan
        </a>
    </div>
    
    <div class="overflow-x-auto">
        <table class="w-full text-left text-sm text-gray-600">
            <thead class="bg-gray-50 text-gray-900 font-medium border-b border-gray-100">
                <tr>
                    <th class="px-6 py-3">Kode</th>
                    <th class="px-6 py-3">Maskapai</th>
                    <th class="px-6 py-3">Rute</th>
                    <th class="px-6 py-3">Jadwal</th>
                    <th class="px-6 py-3">Harga</th>
                    <th class="px-6 py-3">Status</th>
                    <th class="px-6 py-3 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($flights as $flight)
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-6 py-4 font-mono font-medium text-gray-900">{{ $flight->flight_code }}</td>
                    <td class="px-6 py-4">{{ $flight->airline }}</td>
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-2">
                            <span class="font-medium">{{ $flight->fromAirport->code }}</span>
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                            </svg>
                            <span class="font-medium">{{ $flight->toAirport->code }}</span>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="text-gray-900">{{ $flight->departure_time->format('d M Y') }}</div>
                        <div class="text-xs text-gray-500">
                            {{ $flight->departure_time->format('H:i') }} - {{ $flight->arrival_time->format('H:i') }}
                        </div>
                    </td>
                    <td class="px-6 py-4 font-medium text-gray-900">
                        Rp {{ number_format($flight->price, 0, ',', '.') }}
                    </td>
                    <td class="px-6 py-4">
                        @if($flight->status == 'active')
                            <span class="px-2 py-1 text-xs font-medium bg-green-100 text-green-700 rounded-full">Active</span>
                        @else
                            <span class="px-2 py-1 text-xs font-medium bg-gray-100 text-gray-700 rounded-full">Inactive</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-right space-x-2">
                        <a href="{{ route('admin.flights.edit', $flight) }}" class="text-blue-600 hover:text-blue-800 font-medium">Edit</a>
                        <form action="{{ route('admin.flights.destroy', $flight) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus penerbangan ini?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-800 font-medium">Hapus</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-6 py-8 text-center text-gray-500">Belum ada data penerbangan.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($flights->hasPages())
    <div class="px-6 py-4 border-t border-gray-100">
        {{ $flights->links() }}
    </div>
    @endif
</div>
@endsection
