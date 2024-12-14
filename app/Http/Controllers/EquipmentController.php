<?php

namespace App\Http\Controllers;

use App\Models\Equipment;
use Illuminate\Http\Request;

class EquipmentController extends Controller
{
    /**
     * List all equipment.
     */
    public function index()
    {
        return Equipment::all();
    }

    /**
     * Create new equipment.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom' => 'required|string',
            'is_available' => 'boolean',
            'status' => 'string',
        ]);

        return Equipment::create($validated);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update equipment status (e.g., mark as defective)
     */
    public function updateStatus(Request $request, string $id)
    {
        $equipment = Equipment::findOrFail($id);
        $equipment->update([
            'status' => $request->input('status', 'functional'),
            'is_available' => $request->input('is_available', true),
        ]);

        return response()->json(['message' => 'Equipment status updated successfully.', 'equipment' => $equipment]);
    }

    /**
     * Delete equipment.
     */
    public function destroy(string $id)
    {
        $equipment = Equipment::findOrFail($id);
        $equipment->delete();
        return response()->json(['message' => 'Equipment deleted successfully']);
    }
}
