<?php

namespace App\Http\Controllers;

use App\Models\Apiary;
use App\Models\Hive;
use App\Models\HiveSuper;
use App\Traits\LogsHiveActivity;
use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

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
            'action' => 'required|in:move,delete,edit,inspect',
            'hive_ids' => 'required|array',
            'hive_ids.*' => 'exists:hives,id',
            // Move action
            'apiary_id' => 'required_if:action,move|exists:apiaries,id',
            // Edit action
            'type' => 'required_if:action,edit|in:' . implode(',', Hive::getTypeOptions()),
            'location' => 'nullable|string|max:255',
            'location_gps' => 'nullable|string|max:255',
            // Inspect action
            'inspection_date' => 'required_if:action,inspect|date',
            'queen_status' => 'required_if:action,inspect|string|in:' . implode(',', \App\Models\Inspection::getQueenStatusOptions()),
            'population' => 'required_if:action,inspect|integer|min:0|max:100',
            'honey_stores' => 'required_if:action,inspect|integer|min:0|max:100',
            'pollen_stores' => 'required_if:action,inspect|integer|min:0|max:100',
            'brood_pattern' => 'required_if:action,inspect|integer|min:0|max:100',
            'behavior' => 'required_if:action,inspect|integer|min:0|max:100',
            'pests_diseases' => 'required_if:action,inspect|string|in:' . implode(',', \App\Models\Inspection::getPestsAndDiseasesOptions()),
            'treatments' => 'required_if:action,inspect|string|in:' . implode(',', \App\Models\Inspection::getTreatmentsOptions()),
            'notes' => 'nullable|string',
            'anomalies' => 'required_if:action,inspect|string|in:' . implode(',', \App\Models\Inspection::getAnomaliesOptions()),
            'social_states' => 'required_if:action,inspect|string|in:' . implode(',', \App\Models\Inspection::getSocialStatesOptions()),
            'season_states' => 'required_if:action,inspect|string|in:' . implode(',', \App\Models\Inspection::getSeasonStatesOptions()),
            'admin_states' => 'required_if:action,inspect|string|in:' . implode(',', \App\Models\Inspection::getAdminStatesOptions()),
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
            case 'inspect':
                $inspectionData = $request->only([
                    'inspection_date',
                    'queen_status',
                    'population',
                    'honey_stores',
                    'pollen_stores',
                    'brood_pattern',
                    'behavior',
                    'pests_diseases',
                    'treatments',
                    'notes',
                    'anomalies',
                    'social_states',
                    'season_states',
                    'admin_states'
                ]);

                foreach ($hives as $hive) {
                    $hive->inspections()->create($inspectionData);
                    $this->logActivity($hive, 'Inspección en lote creada.');
                }

                return response()->json(['success' => true, 'message' => 'Inspección en lote creada exitosamente.']);
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

    public function generateQrCode(Hive $hive)
    {
        $url = route('hives.show', $hive);
        $qrCode = QrCode::size(200)->generate($url);

        return response($qrCode)->header('Content-Type', 'image/svg+xml');
    }

    public function printQrs(Request $request)
    {
        $hiveIds = explode(',', $request->query('hive_ids'));
        $hives = Hive::whereIn('id', $hiveIds)->get();
        return view('hives.print-qrs', compact('hives'));
    }
}
