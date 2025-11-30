<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Flight;
use App\Models\Airport;
use Illuminate\Http\Request;

class FlightController extends Controller
{
    /**
     * Display a listing of flights
     */
    public function index()
    {
        $flights = Flight::with(['fromAirport', 'toAirport'])
            ->latest()
            ->paginate(15);
            
        return view('admin.flights.index', compact('flights'));
    }

    /**
     * Show the form for creating a new flight
     */
    public function create()
    {
        $airports = Airport::orderBy('city')->get();
        return view('admin.flights.create', compact('airports'));
    }

    /**
     * Store a newly created flight
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'flight_code' => 'required|string|max:255|unique:flights,flight_code',
            'airline' => 'required|string|max:255',
            'from_airport_id' => 'required|exists:airports,id',
            'to_airport_id' => 'required|exists:airports,id|different:from_airport_id',
            'departure_time' => 'required|date',
            'arrival_time' => 'required|date|after:departure_time',
            'price' => 'required|numeric|min:0',
            'seat_class' => 'required|string|max:255',
            'status' => 'required|in:active,inactive',
        ]);

        Flight::create($validated);

        return redirect()
            ->route('admin.flights.index')
            ->with('success', 'Penerbangan berhasil ditambahkan!');
    }

    /**
     * Show the form for editing the specified flight
     */
    public function edit(Flight $flight)
    {
        $airports = Airport::orderBy('city')->get();
        return view('admin.flights.edit', compact('flight', 'airports'));
    }

    /**
     * Update the specified flight
     */
    public function update(Request $request, Flight $flight)
    {
        $validated = $request->validate([
            'flight_code' => 'required|string|max:255|unique:flights,flight_code,' . $flight->id,
            'airline' => 'required|string|max:255',
            'from_airport_id' => 'required|exists:airports,id',
            'to_airport_id' => 'required|exists:airports,id|different:from_airport_id',
            'departure_time' => 'required|date',
            'arrival_time' => 'required|date|after:departure_time',
            'price' => 'required|numeric|min:0',
            'seat_class' => 'required|string|max:255',
            'status' => 'required|in:active,inactive',
        ]);

        $flight->update($validated);

        return redirect()
            ->route('admin.flights.index')
            ->with('success', 'Penerbangan berhasil diupdate!');
    }

    /**
     * Remove the specified flight
     */
    public function destroy(Flight $flight)
    {
        try {
            $flight->delete();
            return redirect()
                ->route('admin.flights.index')
                ->with('success', 'Penerbangan berhasil dihapus!');
        } catch (\Exception $e) {
            return redirect()
                ->route('admin.flights.index')
                ->with('error', 'Gagal menghapus penerbangan. Masih ada booking terkait.');
        }
    }
}
