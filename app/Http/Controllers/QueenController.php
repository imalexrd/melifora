<?php

namespace App\Http\Controllers;

use App\Models\Hive;
use App\Models\Queen;
use App\Models\QueenHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Traits\LogsHiveActivity;

class QueenController extends Controller
{
    use LogsHiveActivity;
    /**
     * Store a newly created queen in storage.
     */
    public function store(Request $request, Hive $hive)
    {
        if ($hive->queen) {
            return redirect()->route('hives.show', $hive)->with('error', 'Esta colmena ya tiene una reina activa.');
        }

        $validated = $request->validate([
            'breed' => 'required|string|max:255',
            'introduction_date' => 'required|date',
            'age' => 'nullable|integer|min:0',
        ]);

        DB::transaction(function () use ($hive, $validated) {
            $queenData = [
                'breed' => $validated['breed'],
                'introduction_date' => $validated['introduction_date'],
                'age' => $validated['age'],
                'status' => 'active',
            ];

            // Since the hive_id is on the queens table, we create it like this
            $queen = new Queen($queenData);
            $hive->queen()->save($queen);


            QueenHistory::create([
                'hive_id' => $hive->id,
                'queen_id' => $queen->id,
                'change_date' => now(),
                'reason' => 'Introducida',
                'notes' => 'Reina inicial añadida a la colmena.',
                'queen_breed' => $queen->breed,
                'queen_introduction_date' => $queen->introduction_date,
                'queen_age' => $queen->age,
            ]);

            $this->logActivity($hive, "Nueva reina de raza {$queen->breed} introducida.");
        });

        return redirect()->route('hives.show', $hive)->with('success', 'Reina añadida exitosamente.');
    }

    /**
     * Update the specified queen in storage.
     */
    public function update(Request $request, Queen $queen)
    {
        $validated = $request->validate([
            'breed' => 'sometimes|required|string|max:255',
            'introduction_date' => 'sometimes|required|date',
            'age' => 'nullable|integer|min:0',
        ]);

        $queen->update($validated);

        $this->logActivity($queen->hive, "Datos de la reina actualizados.");

        return redirect()->route('hives.show', $queen->hive)->with('success', 'Reina actualizada exitosamente.');
    }

    /**
     * Remove the specified queen from storage.
     */
    public function destroy(Request $request, Queen $queen)
    {
        $hive = $queen->hive;
        DB::transaction(function () use ($request, $queen) {

            QueenHistory::create([
                'hive_id' => $queen->hive_id,
                'queen_id' => $queen->id,
                'change_date' => now(),
                'reason' => $request->input('reason', 'Eliminada'),
                'notes' => 'La reina ha sido marcada como eliminada.',
                'queen_breed' => $queen->breed,
                'queen_introduction_date' => $queen->introduction_date,
                'queen_age' => $queen->age,
            ]);

            $queen->update(['status' => 'removed']);

            // Dissociate from hive by setting hive_id to null
            $queen->hive_id = null;
            $queen->save();


            $this->logActivity($hive, "La reina {$queen->breed} fue marcada como eliminada.");
        });

        return redirect()->route('hives.show', $hive)->with('success', 'Reina eliminada y registrada en el historial.');
    }

    /**
     * Replace the specified queen with a new one.
     */
    public function replace(Request $request, Queen $queen)
    {
        $validated = $request->validate([
            'breed' => 'required|string|max:255',
            'introduction_date' => 'required|date',
            'age' => 'nullable|integer|min:0',
            'notes' => 'nullable|string',
        ]);

        $oldQueen = $queen;
        $hive = $oldQueen->hive;

        DB::transaction(function () use ($hive, $oldQueen, $validated, $request) {
            // 1. Create history for the old queen
            QueenHistory::create([
                'hive_id' => $hive->id,
                'queen_id' => $oldQueen->id,
                'change_date' => now(),
                'reason' => 'Reemplazada',
                'notes' => $request->input('notes', 'Reemplazada por una nueva reina.'),
                'queen_breed' => $oldQueen->breed,
                'queen_introduction_date' => $oldQueen->introduction_date,
                'queen_age' => $oldQueen->age,
            ]);

            // 2. Update old queen's status and dissociate
            $oldQueen->update(['status' => 'superseded', 'hive_id' => null]);

            // 3. Create the new queen
            $newQueen = new Queen([
                'breed' => $validated['breed'],
                'introduction_date' => $validated['introduction_date'],
                'age' => $validated['age'],
                'status' => 'active',
            ]);
            $hive->queen()->save($newQueen);

            // 4. Create history for the new queen
            QueenHistory::create([
                'hive_id' => $hive->id,
                'queen_id' => $newQueen->id,
                'change_date' => now(),
                'reason' => 'Introducida (Reemplazo)',
                'notes' => 'Introducida como reemplazo de la reina anterior.',
                'queen_breed' => $newQueen->breed,
                'queen_introduction_date' => $newQueen->introduction_date,
                'queen_age' => $newQueen->age,
            ]);

            $this->logActivity($hive, "Reina {$oldQueen->breed} reemplazada por una nueva reina {$newQueen->breed}.");
        });

        return redirect()->route('hives.show', $hive)->with('success', 'Reina reemplazada exitosamente.');
    }
}
