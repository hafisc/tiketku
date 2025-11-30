<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Flight;
use App\Services\WhatsAppService;
use Illuminate\Http\Request;

/**
 * BookingController (User Side)
 * 
 * Handle semua proses booking tiket untuk user:
 * - Create booking baru
 * - Lihat list booking user
 * - Lihat detail booking
 * - Kirim notifikasi WhatsApp otomatis
 */
class BookingController extends Controller
{
    protected $whatsapp;

    /**
     * Inject WhatsAppService via constructor
     * Ini pakai dependency injection biar gampang testing & maintenance
     */
    public function __construct(WhatsAppService $whatsapp)
    {
        $this->whatsapp = $whatsapp;
    }

    /**
     * Tampilkan list booking milik user yang sedang login
     * 
     * Fitur:
     * - Hanya tampilkan booking milik user sendiri
     * - Load relasi flight & airport biar query lebih efisien
     * - Sort berdasarkan created_at (terbaru dulu)
     * - Pagination 10 per page
     */
    public function index()
    {
        $bookings = auth()->user()
            ->bookings()
            ->with(['flight.fromAirport', 'flight.toAirport'])
            ->latest()
            ->paginate(10);

        return view('pages.bookings.index', compact('bookings'));
    }

    /**
     * Tampilkan detail booking
     * 
     * Security: Pastikan user cuma bisa lihat booking miliknya sendiri
     */
    public function show(Booking $booking)
    {
        // Cek kepemilikan booking (security check)
        // Kalau booking bukan punya user yang login, return 403
        if ($booking->user_id !== auth()->id()) {
            abort(403, 'Unauthorized');
        }

        // Load relasi buat ditampilkan di view
        $booking->load(['flight.fromAirport', 'flight.toAirport', 'user']);

        return view('pages.bookings.show', compact('booking'));
    }

    /**
     * Proses booking tiket baru
     * 
     * Flow:
     * 1. Validasi input dari form booking
     * 2. Hitung total harga (harga flight × jumlah kursi)
     * 3. Generate booking code otomatis (via model observer)
     * 4. Simpan booking ke database dengan status 'pending'
     * 5. Kirim notifikasi WhatsApp ke penumpang
     * 6. Redirect ke halaman detail booking
     */
    public function store(Request $request)
    {
        // Validasi input dari form booking
        $validated = $request->validate([
            'flight_id' => 'required|exists:flights,id',
            'passenger_name' => 'required|string|max:255',
            'passenger_phone' => 'required|string|max:20',
            'seat_count' => 'required|integer|min:1|max:9', // Max 9 kursi per booking
        ]);

        // Ambil data flight
        $flight = Flight::findOrFail($validated['flight_id']);

        // Hitung total harga: harga per kursi × jumlah kursi
        $totalPrice = $flight->price * $validated['seat_count'];

        // Buat booking baru
        // Note: booking_code akan di-generate otomatis via model observer
        $booking = Booking::create([
            'user_id' => auth()->id(),
            'flight_id' => $flight->id,
            'passenger_name' => $validated['passenger_name'],
            'passenger_phone' => $validated['passenger_phone'],
            'seat_count' => $validated['seat_count'],
            'total_price' => $totalPrice,
            'status' => 'pending', // Status awal selalu pending
        ]);

        // Kirim notifikasi WhatsApp ke penumpang
        // Service akan handle API call dan logging otomatis
        $this->whatsapp->sendBookingCreated($booking);

        // Redirect ke detail booking dengan success message
        return redirect()
            ->route('bookings.show', $booking)
            ->with('success', 'Pesanan berhasil dibuat! Kode booking Anda: ' . $booking->booking_code);
    }
}
