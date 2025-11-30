<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Services\WhatsAppService;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    protected $whatsapp;

    public function __construct(WhatsAppService $whatsapp)
    {
        $this->whatsapp = $whatsapp;
    }

    /**
     * Display a listing of all bookings
     */
    public function index(Request $request)
    {
        $query = Booking::with(['user', 'flight.fromAirport', 'flight.toAirport']);

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by date
        if ($request->filled('date')) {
            $query->whereDate('created_at', $request->date);
        }

        // Search by booking code or passenger name
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('booking_code', 'like', "%{$search}%")
                  ->orWhere('passenger_name', 'like', "%{$search}%");
            });
        }

        $bookings = $query->latest()->paginate(20);

        return view('admin.bookings.index', compact('bookings'));
    }

    /**
     * Display the specified booking
     */
    public function show(Booking $booking)
    {
        $booking->load(['user', 'flight.fromAirport', 'flight.toAirport', 'notifications']);
        
        return view('admin.bookings.show', compact('booking'));
    }

    /**
     * Update booking status
     */
    public function updateStatus(Request $request, Booking $booking)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,confirmed,cancelled',
            'notes' => 'nullable|string',
        ]);

        $oldStatus = $booking->status;
        
        $booking->update($validated);

        // Send WhatsApp notification if status changed
        if ($oldStatus !== $validated['status']) {
            $this->whatsapp->sendBookingStatusUpdated($booking);
        }

        return redirect()
            ->route('admin.bookings.show', $booking)
            ->with('success', 'Status booking berhasil diupdate dan notifikasi WhatsApp terkirim!');
    }
}
