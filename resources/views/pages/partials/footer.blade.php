{{-- Footer --}}
<footer class="bg-white border-t border-gray-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
            {{-- Logo & Description --}}
            <div class="col-span-1 md:col-span-2">
                <div class="flex items-center space-x-2 mb-4">
                    <svg class="w-8 h-8 text-[rgba(10,154,242,1)]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                    </svg>
                    <span class="text-2xl font-bold text-[rgba(10,154,242,1)]">Tiketku</span>
                </div>
                <p class="text-gray-600 text-sm mb-4 max-w-md">
                    Platform pemesanan tiket pesawat terpercaya dengan harga terbaik dan layanan 24/7. Terbang ke destinasi impian Anda dengan mudah dan aman.
                </p>
            </div>
            
            {{-- Quick Links --}}
            <div>
                <h3 class="font-semibold text-gray-900 mb-4">Tautan Cepat</h3>
                <ul class="space-y-2">
                    <li><a href="#" class="text-gray-600 hover:text-[rgba(10,154,242,1)] text-sm transition-colors">Tentang Kami</a></li>
                    <li><a href="#" class="text-gray-600 hover:text-[rgba(10,154,242,1)] text-sm transition-colors">Kebijakan Privasi</a></li>
                    <li><a href="#" class="text-gray-600 hover:text-[rgba(10,154,242,1)] text-sm transition-colors">Syarat & Ketentuan</a></li>
                    <li><a href="#" class="text-gray-600 hover:text-[rgba(10,154,242,1)] text-sm transition-colors">FAQ</a></li>
                </ul>
            </div>
            
            {{-- Support --}}
            <div>
                <h3 class="font-semibold text-gray-900 mb-4">Bantuan</h3>
                <ul class="space-y-2">
                    <li><a href="#" class="text-gray-600 hover:text-[rgba(10,154,242,1)] text-sm transition-colors">Pusat Bantuan</a></li>
                    <li><a href="#" class="text-gray-600 hover:text-[rgba(10,154,242,1)] text-sm transition-colors">Hubungi Kami</a></li>
                    <li><a href="#" class="text-gray-600 hover:text-[rgba(10,154,242,1)] text-sm transition-colors">Cara Pembayaran</a></li>
                    <li><a href="#" class="text-gray-600 hover:text-[rgba(10,154,242,1)] text-sm transition-colors">WhatsApp Support</a></li>
                </ul>
            </div>
        </div>
        
        {{-- Copyright --}}
        <div class="border-t border-gray-200 mt-8 pt-8 text-center">
            <p class="text-gray-600 text-sm">
                &copy; {{ date('Y') }} Tiketku. Semua hak cipta dilindungi.
            </p>
        </div>
    </div>
</footer>
