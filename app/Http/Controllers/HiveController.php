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
        $apiaries = Apiary::where('user_id', auth()->id())->get();
        $statuses = Hive::getStatusOptions();
        $types = Hive::getTypeOptions();
        return view('hives.index', compact('hives', 'apiaries', 'statuses', 'types'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $apiaries = Apiary::where('user_id', auth()->id())->get();
        $statuses = Hive::getStatusOptions();
        $types = Hive::getTypeOptions();
        return view('hives.create', compact('apiaries', 'statuses', 'types'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'number_of_hives' => 'required|integer|min:1|max:250',
            'apiary_id' => 'required|exists:apiaries,id',
            'type' => 'required|in:' . implode(',', Hive::getTypeOptions()),
            'status' => 'nullable|in:' . implode(',', Hive::getStatusOptions()),
            'birth_date' => 'nullable|date',
        ]);

        for ($i = 0; $i < $validatedData['number_of_hives']; $i++) {
            $hiveData = [
                'apiary_id' => $validatedData['apiary_id'],
                'type' => $validatedData['type'],
            ];

            if (!empty($validatedData['status'])) {
                $hiveData['status'] = $validatedData['status'];
            }

            if (!empty($validatedData['birth_date'])) {
                $hiveData['birth_date'] = $validatedData['birth_date'];
            }

            Hive::create($hiveData);
        }

        return redirect()->back()->with('success', $validatedData['number_of_hives'] . ' colmenas creadas exitosamente.');
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

    public function bulkActions(Request $request)
    {
        $validatedData = $request->validate([
            'action' => 'required|in:move,delete,edit',
            'hive_ids' => 'required|array',
            'hive_ids.*' => 'exists:hives,id',
            'apiary_id' => 'required_if:action,move|exists:apiaries,id',
            'status' => 'required_if:action,edit|in:' . implode(',', Hive::getStatusOptions()),
            'type' => 'required_if:action,edit|in:' . implode(',', Hive::getTypeOptions()),
            'location_gps' => 'nullable|string|max:255',
        ]);

        $hiveIds = $validatedData['hive_ids'];

        switch ($validatedData['action']) {
            case 'move':
                Hive::whereIn('id', $hiveIds)->update(['apiary_id' => $validatedData['apiary_id']]);
                return response()->json(['success' => true, 'message' => 'Colmenas movidas exitosamente.']);
            case 'delete':
                Hive::whereIn('id', $hiveIds)->delete();
                return response()->json(['success' => true, 'message' => 'Colmenas borradas exitosamente.']);
            case 'edit':
                $updateData = [
                    'status' => $validatedData['status'],
                    'type' => $validatedData['type'],
                ];
                if (!empty($validatedData['location_gps'])) {
                    $updateData['location_gps'] = $validatedData['location_gps'];
                }
                Hive::whereIn('id', $hiveIds)->update($updateData);
                return response()->json(['success' => true, 'message' => 'Colmenas actualizadas exitosamente.']);
        }

        return response()->json(['success' => false, 'message' => 'Invalid action.'], 400);
    }
}
