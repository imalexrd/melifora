<?php

namespace App\Http\Controllers;

use App\Models\Harvest;
use App\Models\Hive;
use Illuminate\Http\Request;
use App\Traits\LogsHiveActivity;

class HarvestController extends Controller
{
    use LogsHiveActivity;

    public function store(Request $request, Hive $hive)
    {
        $validatedData = $request->validate([
            'harvest_date' => 'required|date',
            'quantity_kg' => 'nullable|numeric|min:0',
            'quantity_liters' => 'nullable|numeric|min:0',
            'density' => 'required|numeric|min:0',
            'color_tone' => 'required|string',
            'origin' => 'required|string',
            'notes' => 'nullable|string',
        ]);

        if (empty($validatedData['quantity_kg']) && empty($validatedData['quantity_liters'])) {
            return back()->withErrors(['quantity_kg' => 'Debe proporcionar la cantidad en kilogramos o litros.'])->withInput();
        }

        if (!empty($validatedData['quantity_kg'])) {
            $validatedData['quantity_liters'] = $validatedData['quantity_kg'] / $validatedData['density'];
        } elseif (!empty($validatedData['quantity_liters'])) {
            $validatedData['quantity_kg'] = $validatedData['quantity_liters'] * $validatedData['density'];
        }

        $harvest = $hive->harvests()->create($validatedData);

        $this->logActivity($hive, "Se registró una cosecha de {$harvest->quantity_kg} kg.");

        return redirect()->route('hives.show', $hive)->with('success', 'Cosecha registrada exitosamente.');
    }
}
