<?php

namespace App\Http\Controllers;

use App\Models\Hive;
use App\Models\Inspection;
use Illuminate\Http\Request;

class InspectionController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Hive $hive)
    {
        $validatedData = $request->validate([
            'inspection_date' => 'required|date',
            'queen_status' => 'required|string|in:' . implode(',', Inspection::getQueenStatusOptions()),
            'population' => 'required|integer|min:0|max:100',
            'honey_stores' => 'required|integer|min:0|max:100',
            'pollen_stores' => 'required|integer|min:0|max:100',
            'brood_pattern' => 'required|integer|min:0|max:100',
            'behavior' => 'required|integer|min:0|max:100',
            'pests_diseases' => 'required|string|in:' . implode(',', Inspection::getPestsAndDiseasesOptions()),
            'treatments' => 'required|string|in:' . implode(',', Inspection::getTreatmentsOptions()),
            'notes' => 'nullable|string',
        ]);

        $hive->inspections()->create($validatedData);

        return redirect()->route('hives.show', $hive)->with('success', 'Inspección creada y estado de la colmena actualizado.');
    }
}
