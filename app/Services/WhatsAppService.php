<?php

namespace App\Services;

use App\Models\Notification;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

/**
 * WhatsAppService
 * 
 * Service untuk kirim notifikasi WhatsApp via API Fonnte.
 * 
 * Fitur utama:
 * - Kirim pesan WhatsApp otomatis
 * - Fallback mechanism: kalau token kosong, cuma log ke database
 * - Logging lengkap semua notifikasi (berhasil/gagal)
 * - Helper methods buat booking notifications
 * 
 * Setup:
 * 1. Daftar di https://www.fonnte.com/
 * 2. Dapatkan API token
 * 3. Masukkan ke .env:
 *    WHATSAPP_API_URL=https://api.fonnte.com/send
 *    WHATSAPP_API_TOKEN=your_token_here
 */
class WhatsAppService
{
    protected $apiUrl;
    protected $apiToken;

    /**
     * Load config dari services.php saat instansiasi
     */
    public function __construct()
    {
        $this->apiUrl = config('services.whatsapp.api_url');
        $this->apiToken = config('services.whatsapp.api_token');
    }

    /**
     * Kirim pesan WhatsApp
     *
     * Flow:
     * 1. Buat log notifikasi di database dengan status 'pending'
     * 2. Kalau API token kosong, cuma log aja (fallback mode)
     * 3. Kalau ada token, kirim request ke Fonnte API
     * 4. Update status notifikasi (sent/failed) berdasarkan response
     * 
     * @param string $to Nomor telepon tujuan (format: 628xxx)
     * @param string $message Isi pesan yang mau dikirim
     * @param int|null $bookingId ID booking (opsional, untuk logging)
     * @return bool True kalau berhasil kirim/log, false kalau gagal
     */
    public function sendMessage(string $to, string $message, ?int $bookingId = null): bool
    {
        // Buat log notifikasi di database dulu
        // Status awal = 'pending'
        $notification = Notification::create([
            'booking_id' => $bookingId,
            'to_phone' => $to,
            'message' => $message,
            'status' => 'pending',
        ]);

        try {
            // FALLBACK MODE: Kalau API token kosong
            // Cuma log ke database tanpa kirim ke WhatsApp
            // Berguna buat development lokal
            if (empty($this->apiUrl) || empty($this->apiToken)) {
                Log::info('WhatsApp message (not sent - no API configured):', [
                    'to' => $to,
                    'message' => $message,
                ]);

                // Update status jadi 'sent' walaupun gak beneran kirim
                $notification->update([
                    'status' => 'sent',
                    'sent_at' => now(),
                    'response_payload' => 'No API configured - message logged only',
                ]);

                return true;
            }

            // PRODUCTION MODE: Kirim ke WhatsApp API (Fonnte)
            // Note: Fonnte pakai 'target' bukan 'to' di parameter
            $response = Http::withHeaders([
                'Authorization' => $this->apiToken, // Token langsung, tanpa 'Bearer '
            ])->timeout(10)->post($this->apiUrl, [
                'target' => $to, // Fonnte uses 'target', not 'to'
                'message' => $message,
            ]);

            // Kalau response sukses (status 200-299)
            if ($response->successful()) {
                $notification->update([
                    'status' => 'sent',
                    'sent_at' => now(),
                    'response_payload' => $response->body(),
                ]);

                return true;
            } else {
                // Kalau API return error (status 4xx atau 5xx)
                $notification->update([
                    'status' => 'failed',
                    'response_payload' => $response->body(),
                ]);

                // Log error buat debugging
                Log::error('WhatsApp API error:', [
                    'status' => $response->status(),
                    'body' => $response->body(),
                ]);

                return false;
            }
        } catch (\Exception $e) {
            // Kalau ada exception (network error, timeout, dll)
            $notification->update([
                'status' => 'failed',
                'response_payload' => $e->getMessage(),
            ]);

            Log::error('WhatsApp send error:', [
                'error' => $e->getMessage(),
                'to' => $to,
            ]);

            return false;
        }
    }

    /**
     * Kirim notifikasi saat booking baru dibuat
     * 
     * Format pesan:
     * "Halo {nama}, pesanan tiket Anda dengan kode {booking_code} berhasil dibuat.
     * Status: {status}. Total: Rp {total_price}"
     */
    public function sendBookingCreated($booking): bool
    {
        $message = "Halo {$booking->passenger_name}, pesanan tiket Anda dengan kode {$booking->booking_code} berhasil dibuat. Status: {$booking->status}. Total: Rp " . number_format($booking->total_price, 0, ',', '.');

        return $this->sendMessage($booking->passenger_phone, $message, $booking->id);
    }

    /**
     * Kirim notifikasi saat status booking diupdate
     * 
     * Biasanya dipanggil dari admin saat update status booking
     * (pending -> confirmed atau cancelled)
     */
    public function sendBookingStatusUpdated($booking): bool
    {
        $statusText = $this->getStatusText($booking->status);
        $message = "Halo {$booking->passenger_name}, status pesanan {$booking->booking_code} telah diperbarui menjadi: {$statusText}.";

        return $this->sendMessage($booking->passenger_phone, $message, $booking->id);
    }

    /**
     * Konversi status booking ke text yang lebih user-friendly
     * 
     * Status di database: pending, confirmed, cancelled
     * Ditampilkan ke user: Menunggu Konfirmasi, Dikonfirmasi, Dibatalkan
     */
    private function getStatusText(string $status): string
    {
        return match($status) {
            'pending' => 'Menunggu Konfirmasi',
            'confirmed' => 'Dikonfirmasi',
            'cancelled' => 'Dibatalkan',
            default => $status, // Fallback kalau ada status baru
        };
    }
}
