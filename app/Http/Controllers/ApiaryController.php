<?php

namespace App\Http\Controllers;

use App\Models\Apiary;
use App\Models\ApiaryNote;
use App\Models\Hive;
use App\Traits\LogsApiaryActivity;
use Illuminate\Http\Request;

class ApiaryController extends Controller
{
    use LogsApiaryActivity;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $apiaries = Apiary::withCount('hives')->where('user_id', auth()->id())->oldest()->paginate(10);
        return view('apiaries.index', compact('apiaries'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('apiaries.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
        ]);

        $apiary = new Apiary($validatedData);
        $apiary->user_id = auth()->id();
        $apiary->save();

        $this->logActivity($apiary, 'Apiario creado.');

        return redirect()->route('apiaries.index')->with('success', 'Apiary created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Apiary $apiary)
    {
        $apiary->load(['notes.user', 'activities.user']);
        $query = $apiary->hives();

        // Search
        if ($request->has('search') && $request->search != '') {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // Sort
        $sort = $request->get('sort', 'status');
        $direction = $request->get('direction', 'asc');
        if (in_array($sort, ['name', 'status', 'type', 'birth_date', 'rating', 'updated_at']) && in_array($direction, ['asc', 'desc'])) {
            $query->orderBy($sort, $direction);
        }

        // Pagination size
        $perPage = $request->get('per_page', 10);
        if (!is_numeric($perPage) || $perPage > 250) {
            $perPage = 10;
        }

        $hives = $query->paginate($perPage)->appends($request->query());
        $allApiariesForMoving = Apiary::where('user_id', auth()->id())->where('id', '!=', $apiary->id)->get();
        $allUserApiaries = Apiary::where('user_id', auth()->id())->get();
        $statuses = Hive::getStatusOptions();
        $types = Hive::getTypeOptions();
        $apiaryStatuses = Apiary::getStatusOptions();
        $apiaryStatusColors = Apiary::getStatusColorMap();
        $averageRating = $apiary->hives()->avg('rating');

        return view('apiaries.show', compact('apiary', 'hives', 'sort', 'direction', 'perPage', 'allApiariesForMoving', 'allUserApiaries', 'statuses', 'types', 'apiaryStatuses', 'apiaryStatusColors', 'averageRating'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Apiary $apiary)
    {
        return redirect()->route('apiaries.show', $apiary);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Apiary $apiary)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'location_gps' => 'nullable|string|max:255',
            'status' => 'required|string|in:' . implode(',', Apiary::getStatusOptions()),
        ]);

        $originalStatus = $apiary->status;

        $apiary->update($validatedData);

        if ($originalStatus !== $validatedData['status']) {
            $this->logActivity($apiary, "Estado del apiario actualizado a: {$validatedData['status']}.");
        }

        return redirect()->route('apiaries.show', $apiary)->with('success', 'Apiary updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Apiary $apiary)
    {
        // Forbid deleting the last apiary
        if (auth()->user()->apiaries()->count() === 1) {
            return redirect()->route('apiaries.show', $apiary)->with('error', 'No puedes eliminar tu único apiario. Siempre debe existir al menos uno.');
        }

        if ($apiary->hives()->count() > 0) {
            $hivesAction = $request->input('hives_action');

            if ($hivesAction === 'move') {
                $moveToApiaryId = $request->input('move_to_apiary_id');
                $moveToApiary = Apiary::where('user_id', auth()->id())->findOrFail($moveToApiaryId);

                // Move hives
                foreach ($apiary->hives as $hive) {
                    $hive->apiary_id = $moveToApiary->id;
                    $hive->save();
                    $this->logActivity($apiary, "Colmena {$hive->name} movida al apiario {$moveToApiary->name}.");
                }
                $this->logActivity($apiary, "Todas las colmenas movidas a {$moveToApiary->name}.");

            } elseif ($hivesAction === 'delete') {
                // Delete hives
                foreach ($apiary->hives as $hive) {
                    $this->logActivity($apiary, "Colmena {$hive->name} eliminada junto con el apiario.");
                    $hive->delete();
                }
            } else {
                // No action specified, so we prevent deletion
                return redirect()->route('apiaries.show', $apiary)->with('error', 'Por favor, especifica qué hacer con las colmenas del apiario.');
            }
        }

        $apiaryName = $apiary->name;
        $apiary->delete();

        // We don't log here because the trait will do it, but we prepare the message for the redirect
        // $this->logActivity($apiary, "Apiario {$apiaryName} eliminado.");

        return redirect()->route('apiaries.index')->with('success', "Apiario '{$apiaryName}' eliminado con éxito.");
    }

    public function storeNote(Request $request, Apiary $apiary)
    {
        $request->validate(['content' => 'required|string']);

        $note = $apiary->notes()->create([
            'user_id' => auth()->id(),
            'content' => $request->content,
        ]);

        $note->load('user');

        return response()->json($note);
    }

    public function updateNote(Request $request, Apiary $apiary, ApiaryNote $note)
    {
        if ($note->user_id !== auth()->id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $request->validate(['content' => 'required|string']);

        $note->update(['content' => $request->content]);

        $note->load('user');

        return response()->json($note);
    }

    public function destroyNote(Apiary $apiary, ApiaryNote $note)
    {
        if ($note->user_id !== auth()->id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $note->delete();

        return response()->json(['success' => true]);
    }
}
