<?php

namespace App\Http\Controllers;

use App\Models\Apiary;
use App\Models\Hive;
use App\Models\HiveSuper;
use App\Traits\LogsHiveActivity;
use Illuminate\Http\Request;

class HiveController extends Controller
{
    use LogsHiveActivity;
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Hive::whereHas('apiary', function ($query) {
            $query->where('user_id', auth()->id());
        })->with('apiary');

        // Search
        if ($request->has('search') && $request->search != '') {
            $searchTerm = '%' . $request->search . '%';
            $query->where(function ($q) use ($searchTerm) {
                $q->where('name', 'like', $searchTerm)
                  ->orWhereHas('apiary', function ($q) use ($searchTerm) {
                      $q->where('name', 'like', $searchTerm);
                  });
            });
        }

        // Sort
        $sort = $request->get('sort', 'name');
        $direction = $request->get('direction', 'asc');
        $sortableFields = ['name', 'type', 'birth_date', 'rating', 'updated_at'];

        if (in_array($sort, $sortableFields)) {
            $query->orderBy($sort, $direction);
        } elseif ($sort === 'apiary') {
            $query->join('apiaries', 'hives.apiary_id', '=', 'apiaries.id')
                  ->orderBy('apiaries.name', $direction)
                  ->select('hives.*');
        }


        // Pagination size
        $perPage = $request->get('per_page', 10);
        if (!is_numeric($perPage) || $perPage > 250) {
            $perPage = 10;
        }

        $hives = $query->paginate($perPage)->appends($request->query());

        $apiaries = Apiary::where('user_id', auth()->id())->get();
        $types = Hive::getTypeOptions();

        return view('hives.index', compact('hives', 'apiaries', 'types', 'sort', 'direction', 'perPage'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $apiaries = Apiary::where('user_id', auth()->id())->get();
        $types = Hive::getTypeOptions();
        return view('hives.create', compact('apiaries', 'types'));
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
            'birth_date' => 'nullable|date',
        ]);

        $apiary = Apiary::findOrFail($validatedData['apiary_id']);

        for ($i = 0; $i < $validatedData['number_of_hives']; $i++) {
            $hiveData = [
                'apiary_id' => $validatedData['apiary_id'],
                'type' => $validatedData['type'],
            ];

            if (!empty($validatedData['birth_date'])) {
                $hiveData['birth_date'] = $validatedData['birth_date'];
            }

            $hive = Hive::create($hiveData);
            $this->logActivity($hive, 'Colmena creada.');
        }

        return redirect()->back()->with('success', $validatedData['number_of_hives'] . ' colmenas creadas exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Hive $hive)
    {
        $hive->load([
            'queen',
            'queenHistories',
            'inspections' => fn($query) => $query->orderBy('inspection_date', 'desc'),
            'harvests',
            'latestHarvest',
            'tags',
            'notes.user',
            'activities.user',
            'hiveSupers',
            'states'
        ]);
        $apiaries = Apiary::where('user_id', auth()->id())->get();
        $types = Hive::getTypeOptions();
        $lastInspection = $hive->inspections()->latest('inspection_date')->first();
        $unassignedSupers = HiveSuper::whereNull('hive_id')->get();
        $states = \App\Models\State::all()->groupBy('category');

        return view('hives.show', compact('hive', 'apiaries', 'types', 'lastInspection', 'unassignedSupers', 'states'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Hive $hive)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'qr_code' => 'nullable|string|max:255',
            'type' => 'required|in:' . implode(',', Hive::getTypeOptions()),
            'birth_date' => 'nullable|date',
            'location' => 'nullable|string|max:255',
            'location_gps' => 'nullable|string|max:255',
        ]);

        $hive->update($validatedData);

        $this->logActivity($hive, 'Colmena actualizada.');

        return redirect()->route('hives.show', $hive)->with('success', 'Hive updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Hive $hive)
    {
        // Unassign any hive supers before deleting the hive
        $hive->hiveSupers()->update(['hive_id' => null]);

        $this->logActivity($hive, "Colmena {$hive->name} eliminada.");
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
            'type' => 'required_if:action,edit|in:' . implode(',', Hive::getTypeOptions()),
            'location' => 'nullable|string|max:255',
            'location_gps' => 'nullable|string|max:255',
        ]);

        $hiveIds = $validatedData['hive_ids'];
        $hives = Hive::whereIn('id', $hiveIds)->get();

        switch ($validatedData['action']) {
            case 'move':
                $destinationApiary = Apiary::findOrFail($validatedData['apiary_id']);

                foreach ($hives as $hive) {
                    $this->logActivity($hive, "Movida a {$destinationApiary->name}.");
                    $hive->update(['apiary_id' => $validatedData['apiary_id']]);
                }

                return response()->json(['success' => true, 'message' => 'Colmenas movidas exitosamente.']);
            case 'delete':
                foreach ($hives as $hive) {
                    $hive->hiveSupers()->update(['hive_id' => null]);
                    $this->logActivity($hive, 'Colmena eliminada.');
                    $hive->delete();
                }
                return response()->json(['success' => true, 'message' => 'Colmenas borradas exitosamente.']);
            case 'edit':
                $updateData = [
                    'type' => $validatedData['type'],
                ];
                if (array_key_exists('location', $validatedData) && !is_null($validatedData['location'])) {
                    $updateData['location'] = $validatedData['location'];
                }
                if (array_key_exists('location_gps', $validatedData) && !is_null($validatedData['location_gps'])) {
                    $updateData['location_gps'] = $validatedData['location_gps'];
                }

                foreach ($hives as $hive) {
                    $hive->update($updateData);
                    $this->logActivity($hive, 'Colmena actualizada en lote.');
                }

                return response()->json(['success' => true, 'message' => 'Colmenas actualizadas exitosamente.']);
        }

        return response()->json(['success' => false, 'message' => 'Invalid action.'], 400);
    }

    public function updateStates(Request $request, Hive $hive)
    {
        $request->validate([
            'states' => 'nullable|array',
            'states.*' => 'exists:states,id',
        ]);

        $inspectionStates = $hive->states()->wherePivot('cause', 'like', 'Inspección del%')->get();
        $newManualStates = $request->input('states', []);

        $statesToSync = [];

        // Add inspection states to the sync list
        foreach ($inspectionStates as $state) {
            $statesToSync[$state->id] = ['cause' => $state->pivot->cause];
        }

        // Add new manual states to the sync list
        foreach ($newManualStates as $stateId) {
            if (!isset($statesToSync[$stateId])) {
                $statesToSync[$stateId] = ['cause' => 'Manual'];
            }
        }

        $hive->states()->sync($statesToSync);

        return redirect()->route('hives.show', $hive)->with('success', 'Estados de la colmena actualizados.');
    }
}
