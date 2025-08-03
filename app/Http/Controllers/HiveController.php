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
        // Add validation logic here
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'apiary_id' => 'required|exists:apiaries,id',
            'slug' => 'required|string|max:255|unique:hives',
            'type' => 'required|in:Langstroth,Dadant,Layens,Top-Bar,Warre,Flow',
            // Add other validation rules as needed
        ]);

        $hive = Hive::create($validatedData);

        return redirect()->route('hives.show', $hive);
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
            'slug' => 'required|string|max:255|unique:hives,slug,' . $hive->id,
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
