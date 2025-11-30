@extends('layouts.auth')

@section('title', 'Tiketku - Daftar')

@section('content')
<div class="max-w-md mx-auto">
    {{-- Card --}}
    <div class="bg-white rounded-2xl shadow-2xl p-8 border border-gray-100">
        {{-- Header --}}
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Buat Akun Baru</h1>
            <p class="text-gray-600">Daftar sekarang dan mulai petualangan Anda!</p>
        </div>

        {{-- Form --}}
        <form action="{{ route('register') }}" method="POST" class="space-y-5">
            @csrf
            
            {{-- Nama Lengkap --}}
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Nama Lengkap</label>
                <input 
                    type="text" 
                    id="name" 
                    name="name" 
                    value="{{ old('name') }}"
                    required 
                    autofocus
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[rgba(10,154,242,0.5)] focus:border-[rgba(10,154,242,1)] transition-all @error('name') border-red-500 @enderror"
                    placeholder="Nama Lengkap"
                >
                @error('name')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Email --}}
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                <input 
                    type="email" 
                    id="email" 
                    name="email" 
                    value="{{ old('email') }}"
                    required
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[rgba(10,154,242,0.5)] focus:border-[rgba(10,154,242,1)] transition-all @error('email') border-red-500 @enderror"
                    placeholder="nama@email.com"
                >
                @error('email')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- No. Telepon --}}
            <div>
                <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">No. Telepon</label>
                <input 
                    type="tel" 
                    id="phone" 
                    name="phone" 
                    value="{{ old('phone') }}"
                    required
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[rgba(10,154,242,0.5)] focus:border-[rgba(10,154,242,1)] transition-all @error('phone') border-red-500 @enderror"
                    placeholder="08xxxxx"
                >
                @error('phone')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Password --}}
            <div>
                <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Password</label>
                <input 
                    type="password" 
                    id="password" 
                    name="password" 
                    required
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[rgba(10,154,242,0.5)] focus:border-[rgba(10,154,242,1)] transition-all @error('password') border-red-500 @enderror"
                    placeholder="••••••••"
                >
                @error('password')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
                <p class="mt-1 text-xs text-gray-500">Minimal 8 karakter</p>
            </div>

            {{-- Konfirmasi Password --}}
            <div>
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">Konfirmasi Password</label>
                <input 
                    type="password" 
                    id="password_confirmation" 
                    name="password_confirmation" 
                    required
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[rgba(10,154,242,0.5)] focus:border-[rgba(10,154,242,1)] transition-all"
                    placeholder="••••••••"
                >
            </div>

            {{-- Terms & Conditions --}}
            <div class="flex items-start">
                <input 
                    type="checkbox" 
                    id="terms" 
                    name="terms" 
                    required
                    class="w-4 h-4 mt-1 text-[rgba(10,154,242,1)] border-gray-300 rounded focus:ring-[rgba(10,154,242,0.5)]"
                >
                <label for="terms" class="ml-2 text-sm text-gray-600">
                    Saya setuju dengan <a href="#" class="text-[rgba(10,154,242,1)] hover:underline">Syarat & Ketentuan</a> dan <a href="#" class="text-[rgba(10,154,242,1)] hover:underline">Kebijakan Privasi</a>
                </label>
            </div>

            {{-- Submit Button --}}
            <button 
                type="submit" 
                class="w-full px-6 py-3 bg-[rgba(10,154,242,1)] text-white rounded-lg font-semibold shadow-lg hover:shadow-xl hover:bg-[rgba(10,154,242,0.9)] transition-all transform hover:-translate-y-0.5"
            >
                Daftar Sekarang
            </button>
        </form>

        {{-- Divider --}}
        <div class="relative my-6">
            <div class="absolute inset-0 flex items-center">
                <div class="w-full border-t border-gray-300"></div>
            </div>
            <div class="relative flex justify-center text-sm">
                <span class="px-4 bg-white text-gray-500">Atau daftar dengan</span>
            </div>
        </div>

        {{-- Social Login --}}
        {{-- <div class="grid grid-cols-2 gap-4">
            <button class="px-4 py-3 border-2 border-gray-300 rounded-lg font-medium text-gray-700 hover:bg-gray-50 transition-all flex items-center justify-center gap-2">
                <svg class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"/>
                    <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/>
                    <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" fill="#FBBC05"/>
                    <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335"/>
                </svg>
                Google
            </button>
            <button class="px-4 py-3 border-2 border-gray-300 rounded-lg font-medium text-gray-700 hover:bg-gray-50 transition-all flex items-center justify-center gap-2">
                <svg class="w-5 h-5" fill="#1877F2" viewBox="0 0 24 24">
                    <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                </svg>
                Facebook
            </button>
        </div> --}}

        {{-- Login Link --}}
        <p class="mt-6 text-center text-sm text-gray-600">
            Sudah punya akun? 
            <a href="{{ route('login') }}" class="font-semibold text-[rgba(10,154,242,1)] hover:underline">Masuk sekarang</a>
        </p>
    </div>

    {{-- Back to Home --}}
    <div class="text-center mt-6">
        <a href="/" class="text-sm text-gray-600 hover:text-[rgba(10,154,242,1)] transition-colors">
            ← Kembali ke Beranda
        </a>
    </div>
</div>
@endsection
