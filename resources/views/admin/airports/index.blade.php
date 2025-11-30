@extends('layouts.admin')

@section('header', 'Manajemen Bandara')

@section('content')
<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center">
        <h2 class="text-lg font-semibold text-gray-900">Daftar Bandara</h2>
        <a href="{{ route('admin.airports.create') }}" class="px-4 py-2 bg-[rgba(10,154,242,1)] text-white rounded-lg hover:bg-[rgba(10,154,242,0.9)] transition-colors text-sm font-medium">
            + Tambah Bandara
        </a>
    </div>
    
    <div class="overflow-x-auto">
        <table class="w-full text-left text-sm text-gray-600">
            <thead class="bg-gray-50 text-gray-900 font-medium border-b border-gray-100">
                <tr>
                    <th class="px-6 py-3">Kode</th>
                    <th class="px-6 py-3">Nama Bandara</th>
                    <th class="px-6 py-3">Kota</th>
                    <th class="px-6 py-3">Negara</th>
                    <th class="px-6 py-3 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($airports as $airport)
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-6 py-4 font-mono font-medium text-gray-900">{{ $airport->code }}</td>
                    <td class="px-6 py-4">{{ $airport->name }}</td>
                    <td class="px-6 py-4">{{ $airport->city }}</td>
                    <td class="px-6 py-4">{{ $airport->country }}</td>
                    <td class="px-6 py-4 text-right space-x-2">
                        <a href="{{ route('admin.airports.edit', $airport) }}" class="text-blue-600 hover:text-blue-800 font-medium">Edit</a>
                        <form action="{{ route('admin.airports.destroy', $airport) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus bandara ini?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-800 font-medium">Hapus</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-8 text-center text-gray-500">Belum ada data bandara.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($airports->hasPages())
    <div class="px-6 py-4 border-t border-gray-100">
        {{ $airports->links() }}
    </div>
    @endif
</div>
@endsection
