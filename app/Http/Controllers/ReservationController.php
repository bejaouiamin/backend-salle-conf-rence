<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reservation;
use App\Notifications\ReservationReminder;

class ReservationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Reservation::with('salle', 'user')->get();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
   // Update a reservation
   public function update(Request $request, $id)
    {
        $reservation = Reservation::findOrFail($id);
        $validated = $request->validate([
            'salle_id' => 'required|exists:salles,id',
            'user_id' => 'required|exists:users,id',
            'start_time' => 'required|date|after:now',
            'end_time' => 'required|date|after:start_time',
            'preferences' => 'nullable|string',
            'resources' => 'nullable|string',
        ]);

        $reservation->update($validated);
        return response()->json(['message' => 'Reservation updated successfully', 'reservation' => $reservation]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $reservation = Reservation::findOrFail($id);
        $reservation->delete();
        return response()->json(['message' => 'Reservation cancelled successfully']);
    }

    /**
     * Send a reminder notification for a reservation.
     */
    public function sendReminder($reservationId)
    {
        $reservation = Reservation::with('salle')->findOrFail($reservationId); // Include salle relationship
        $user = $reservation->user;
    
        $user->notify(new ReservationReminder($reservation));
    }
    
}
