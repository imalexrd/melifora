<?php

namespace App\Http\Controllers;

use App\Models\Apiary;
use App\Models\Hive;
use Illuminate\Http\Request;

class HiveController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $hives = Hive::whereHas('apiary', function ($query) {
            $query->where('user_id', auth()->id());
        })->latest()->paginate(10);
        return view('hives.index', compact('hives'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $apiaries = Apiary::all();
        return view('hives.create', compact('apiaries'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'number_of_hives' => 'required|integer|min:1|max:250',
            'apiary_id' => 'required|exists:apiaries,id',
            'type' => 'required|in:Langstroth,Dadant,Layens,Top-Bar,Warre,Flow',
        ]);

        for ($i = 0; $i < $validatedData['number_of_hives']; $i++) {
            Hive::create([
                'name' => 'Colmena #' . ($i + 1),
                'apiary_id' => $validatedData['apiary_id'],
                'type' => $validatedData['type'],
            ]);
        }

        return redirect()->route('hives.index')->with('success', $validatedData['number_of_hives'] . ' colmenas creadas exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Hive $hive)
    {
        $hive->load('queen', 'queenHistories', 'inspections', 'events', 'tags');
        return view('hives.show', compact('hive'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Hive $hive)
    {
        $apiaries = Apiary::all();
        return view('hives.edit', compact('hive', 'apiaries'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Hive $hive)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'qr_code' => 'nullable|string|max:255',
            'rating' => 'nullable|integer|min:0|max:100',
            'type' => 'required|in:Langstroth,Dadant,Layens,Top-Bar,Warre,Flow',
            'birth_date' => 'nullable|date',
            'location' => 'nullable|string|max:255',
            'status' => 'required|in:Desconocido,Activa,Invernando,Enjambrazon,Despoblada,Huerfana,Zanganera,En formacion,Revision,Mantenimiento,Alimentacion Artificial,Crianza de reinas,Pillaje,Pillera,Union,Sin uso',
            'notes' => 'nullable|string',
        ]);

        $hive->update($validatedData);

        return redirect()->route('hives.show', $hive)->with('success', 'Hive updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Hive $hive)
    {
        $hive->delete();

        return redirect()->route('hives.index')->with('success', 'Hive deleted successfully.');
    }
}
