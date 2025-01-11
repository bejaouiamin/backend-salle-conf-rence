<?php

namespace App\Http\Controllers;

use App\Models\Salle;
use App\Models\Reservation;
use App\Mail\ReservationConfirmation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

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
        // Validate the request data, excluding user_id
        $validated = $request->validate([
            'salle_id' => 'required|exists:salles,id',
            'start_time' => 'required|date|after:now',
            'end_time' => 'required|date|after:start_time',
            'preferences' => 'nullable|string',
            'resources' => 'nullable|string',
            'email' => 'required|email',  // Validate email
        ]);

        // Check if the salle is already reserved for the requested time
        $isReserved = Reservation::where('salle_id', $validated['salle_id'])
            ->where(function ($query) use ($validated) {
                $query->whereBetween('start_time', [$validated['start_time'], $validated['end_time']])
                    ->orWhereBetween('end_time', [$validated['start_time'], $validated['end_time']]);
            })
            ->exists();

        if ($isReserved) {
            return response()->json(['message' => 'La salle est déjà réservée pour cette plage horaire.'], 400);
        }

        // Check if the user is authenticated
        if (!auth()->check()) {
            return response()->json(['message' => 'You must be logged in to make a reservation.'], 401);
        }

        // Add the authenticated user's ID if available
        $validated['user_id'] = auth()->id();


        // Create the reservation
        $reservation = Reservation::create($validated);

        // Send confirmation email
        $this->sendConfirmationEmail($reservation);

        return response()->json(['message' => 'Réservation réussie, un email de confirmation a été envoyé!', 'reservation' => $reservation]);
    }


    protected function sendConfirmationEmail($reservation)
    {
        // Send the confirmation email to the provided email address
        Mail::to($reservation->email)->send(new ReservationConfirmation($reservation));
    }


    public function getReservations()
    {
        return Reservation::with('salle')->get();
    }
}
