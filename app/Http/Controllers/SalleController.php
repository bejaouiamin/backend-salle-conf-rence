<?php

namespace App\Http\Controllers;

use App\Models\Salle;
use App\Models\Reservation;
use Illuminate\Http\Request;

class SalleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Salle::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom' => 'required|string',
            'capacite' => 'required|integer',
            'localisation' => 'required|string',
            'equipements' => 'nullable|string',
        ]);

        return Salle::create($validated);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return Salle::findOrFail($id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $salle = Salle::findOrFail($id);
        $salle->update($request->all());
        return $salle;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $salle = Salle::findOrFail($id);
        $salle->delete();
        return response()->json(['message' => 'Salle supprimée']);
    }

    // app/Http/Controllers/SalleController.php
    public function createReservation(Request $request)
    {
        $validated = $request->validate([
            'salle_id' => 'required|exists:salles,id',
            'start_time' => 'required|date',
            'end_time' => 'required|date|after:start_time',
            'preferences' => 'nullable|string',
            'resources' => 'nullable|string',
        ]);

        $reservation = Reservation::create($validated);

        return response()->json(['message' => 'Réservation créée avec succès', 'reservation' => $reservation]);
    }

    public function getReservations()
    {
        return Reservation::with('salle')->get();
    }
}
