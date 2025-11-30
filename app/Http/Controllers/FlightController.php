<?php

namespace App\Http\Controllers;

use App\Models\Flight;
use App\Models\Airport;
use Illuminate\Http\Request;

/**
 * FlightController (User Side)
 * 
 * Handle pencarian dan detail penerbangan untuk user.
 * Fitur utama:
 * - List penerbangan dengan filter (dari, ke, tanggal, kelas)
 * - Detail penerbangan sebelum booking
 */
class FlightController extends Controller
{
    /**
     * Tampilkan halaman search + list penerbangan
     * 
     * Query parameters dari form search:
     * - from: ID bandara asal
     * - to: ID bandara tujuan
     * - date: Tanggal keberangkatan
     * - class: Kelas pesawat (Economy/Business/First Class)
     */
    public function index(Request $request)
    {
        // Ambil semua bandara buat dropdown di form pencarian
        $airports = Airport::orderBy('city')->get();
        
        // Query dasar: ambil flight yang aktif, dengan relasi bandara asal/tujuan
        $query = Flight::with(['fromAirport', 'toAirport'])
            ->active(); // Scope: hanya yang status = 'active'

        // Filter bandara asal (kalau ada parameter 'from')
        if ($request->filled('from')) {
            $query->where('from_airport_id', $request->from);
        }

        // Filter bandara tujuan (kalau ada parameter 'to')
        if ($request->filled('to')) {
            $query->where('to_airport_id', $request->to);
        }

        // Filter tanggal keberangkatan
        // Pakai whereDate karena departure_time itu datetime
        if ($request->filled('date')) {
            $query->whereDate('departure_time', $request->date);
        }

        // Filter kelas pesawat
        if ($request->filled('class')) {
            $query->where('seat_class', $request->class);
        }

        // Urutkan berdasarkan waktu keberangkatan (terbaru dulu) dan paginate
        $flights = $query->latest('departure_time')->paginate(10);

        return view('pages.flights.index', compact('flights', 'airports'));
    }

    /**
     * Tampilkan detail penerbangan
     * 
     * Halaman ini ditampilkan sebelum user melakukan booking.
     * Menampilkan info lengkap penerbangan dan form booking.
     */
    public function show(Flight $flight)
    {
        // Load relasi bandara buat ditampilkan di view
        $flight->load(['fromAirport', 'toAirport']);
        
        return view('pages.flights.show', compact('flight'));
    }
}
