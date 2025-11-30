@extends('layouts.auth')

@section('title', 'Tiketku - Lupa Password')

@section('content')
<div class="max-w-md mx-auto">
    {{-- Card --}}
    <div class="bg-white rounded-2xl shadow-2xl p-8 border border-gray-100">
        {{-- Header --}}
        <div class="text-center mb-8">
            <div class="w-16 h-16 bg-[rgba(10,154,242,0.1)] rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8 text-[rgba(10,154,242,1)]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"></path>
                </svg>
            </div>
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Lupa Password?</h1>
            <p class="text-gray-600">Tidak masalah! Masukkan email Anda dan kami akan mengirimkan link untuk reset password.</p>
        </div>

        {{-- Success Message (jika ada) --}}
        @if (session('status'))
            <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-lg">
                <div class="flex items-start">
                    <svg class="w-5 h-5 text-green-600 mt-0.5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <p class="text-sm text-green-800">{{ session('status') }}</p>
                </div>
            </div>
        @endif

        {{-- Form --}}
        <form action="{{ route('password.email') }}" method="POST" class="space-y-5">
            @csrf
            
            {{-- Email --}}
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                <input 
                    type="email" 
                    id="email" 
                    name="email" 
                    value="{{ old('email') }}"
                    required 
                    autofocus
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[rgba(10,154,242,0.5)] focus:border-[rgba(10,154,242,1)] transition-all @error('email') border-red-500 @enderror"
                    placeholder="nama@email.com"
                >
                @error('email')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Submit Button --}}
            <button 
                type="submit" 
                class="w-full px-6 py-3 bg-[rgba(10,154,242,1)] text-white rounded-lg font-semibold shadow-lg hover:shadow-xl hover:bg-[rgba(10,154,242,0.9)] transition-all transform hover:-translate-y-0.5"
            >
                Kirim Link Reset Password
            </button>
        </form>

        {{-- Back to Login --}}
        <div class="mt-6 text-center">
            <a href="{{ route('login') }}" class="text-sm text-gray-600 hover:text-[rgba(10,154,242,1)] transition-colors flex items-center justify-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Kembali ke Login
            </a>
        </div>
    </div>

    {{-- Help Section --}}
    <div class="mt-8 bg-blue-50 rounded-xl p-6 border border-blue-100">
        <h3 class="font-semibold text-gray-900 mb-2">Butuh Bantuan?</h3>
        <p class="text-sm text-gray-600 mb-4">
            Jika Anda mengalami kesulitan, tim support kami siap membantu Anda.
        </p>
        <div class="flex flex-col sm:flex-row gap-3">
            <a href="https://wa.me/6281234567890" class="flex-1 px-4 py-2 bg-[rgba(10,154,242,1)] text-white rounded-lg font-medium text-center hover:bg-[rgba(10,154,242,0.9)] transition-all flex items-center justify-center gap-2">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                </svg>
                Hubungi WhatsApp
            </a>
            <a href="mailto:support@flynow.com" class="flex-1 px-4 py-2 border-2 border-[rgba(10,154,242,1)] text-[rgba(10,154,242,1)] rounded-lg font-medium text-center hover:bg-[rgba(10,154,242,0.1)] transition-all flex items-center justify-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                </svg>
                Email Support
            </a>
        </div>
    </div>

    {{-- Back to Home --}}
    <div class="text-center mt-6">
        <a href="/" class="text-sm text-gray-600 hover:text-[rgba(10,154,242,1)] transition-colors">
            ← Kembali ke Beranda
        </a>
    </div>
</div>
@endsection
