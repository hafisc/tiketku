<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Airport;
use Illuminate\Http\Request;

class AirportController extends Controller
{
    /**
     * Display a listing of airports
     */
    public function index()
    {
        $airports = Airport::latest()->paginate(15);
        return view('admin.airports.index', compact('airports'));
    }

    /**
     * Show the form for creating a new airport
     */
    public function create()
    {
        return view('admin.airports.create');
    }

    /**
     * Store a newly created airport
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'code' => 'required|string|max:10|unique:airports,code',
            'name' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'country' => 'required|string|max:255',
        ]);

        Airport::create($validated);

        return redirect()
            ->route('admin.airports.index')
            ->with('success', 'Bandara berhasil ditambahkan!');
    }

    /**
     * Show the form for editing the specified airport
     */
    public function edit(Airport $airport)
    {
        return view('admin.airports.edit', compact('airport'));
    }

    /**
     * Update the specified airport
     */
    public function update(Request $request, Airport $airport)
    {
        $validated = $request->validate([
            'code' => 'required|string|max:10|unique:airports,code,' . $airport->id,
            'name' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'country' => 'required|string|max:255',
        ]);

        $airport->update($validated);

        return redirect()
            ->route('admin.airports.index')
            ->with('success', 'Bandara berhasil diupdate!');
    }

    /**
     * Remove the specified airport
     */
    public function destroy(Airport $airport)
    {
        try {
            $airport->delete();
            return redirect()
                ->route('admin.airports.index')
                ->with('success', 'Bandara berhasil dihapus!');
        } catch (\Exception $e) {
            return redirect()
                ->route('admin.airports.index')
                ->with('error', 'Gagal menghapus bandara. Masih ada penerbangan terkait.');
        }
    }
}
