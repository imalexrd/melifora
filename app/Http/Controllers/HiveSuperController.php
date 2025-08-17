<?php

namespace App\Http\Controllers;

use App\Models\Hive;
use App\Models\HiveSuper;
use Illuminate\Http\Request;

class HiveSuperController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = HiveSuper::with('hive');

        // Search
        if ($request->has('search') && $request->search != '') {
            $searchTerm = '%' . $request->search . '%';
            $query->where('tracking_code', 'like', $searchTerm)
                  ->orWhereHas('hive', function ($q) use ($searchTerm) {
                      $q->where('name', 'like', $searchTerm);
                  });
        }

        // Sort
        $sort = $request->get('sort', 'created_at');
        $direction = $request->get('direction', 'desc');
        $sortableFields = ['tracking_code', 'created_at'];

        if (in_array($sort, $sortableFields)) {
            $query->orderBy($sort, $direction);
        } elseif ($sort === 'hive') {
            $query->leftJoin('hives', 'hive_supers.hive_id', '=', 'hives.id')
                  ->orderBy('hives.name', $direction)
                  ->select('hive_supers.*');
        }

        // Pagination size
        $perPage = $request->get('per_page', 10);
        if (!is_numeric($perPage) || $perPage > 100) {
            $perPage = 10;
        }

        $hiveSupers = $query->paginate($perPage)->appends($request->query());

        // Stats
        $total = HiveSuper::count();
        $assigned = HiveSuper::whereNotNull('hive_id')->count();
        $unassigned = $total - $assigned;

        $allHives = Hive::whereHas('apiary', fn($query) => $query->where('user_id', auth()->id()))->get();

        return view('hive_supers.index', compact('hiveSupers', 'total', 'assigned', 'unassigned', 'sort', 'direction', 'perPage', 'allHives'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'number_of_supers' => 'required|integer|min:1|max:100',
        ]);

        for ($i = 0; $i < $request->number_of_supers; $i++) {
            HiveSuper::create();
        }

        return redirect()->route('hive_supers.index')->with('success', $request->number_of_supers . ' alzas creadas exitosamente.');
    }

    /**
     * Assign a hive super to a hive.
     */
    public function assign(Request $request, Hive $hive)
    {
        $request->validate([
            'hive_super_id' => 'required|exists:hive_supers,id',
        ]);

        $hiveSuper = HiveSuper::find($request->hive_super_id);

        if ($hiveSuper->hive_id) {
            return redirect()->back()->with('error', 'Esta alza ya está asignada a otra colmena.');
        }

        $hiveSuper->hive_id = $hive->id;
        $hiveSuper->save();

        return redirect()->route('hives.show', $hive)->with('success', 'Alza asignada exitosamente.');
    }

    /**
     * Unassign a hive super from a hive.
     */
    public function unassign(HiveSuper $hive_super)
    {
        $hive = $hive_super->hive;
        $hive_super->hive_id = null;
        $hive_super->save();

        return redirect()->route('hives.show', $hive)->with('success', 'Alza desasignada exitosamente.');
    }

    public function bulkActions(Request $request)
    {
        $validatedData = $request->validate([
            'action' => 'required|in:delete,unassign,assign',
            'hive_super_ids' => 'required|array',
            'hive_super_ids.*' => 'exists:hive_supers,id',
            'hive_id' => 'required_if:action,assign|exists:hives,id',
        ]);

        $hiveSuperIds = $validatedData['hive_super_ids'];

        switch ($validatedData['action']) {
            case 'delete':
                HiveSuper::whereIn('id', $hiveSuperIds)->delete();
                return response()->json(['success' => true, 'message' => 'Alzas eliminadas exitosamente.']);

            case 'unassign':
                HiveSuper::whereIn('id', $hiveSuperIds)->update(['hive_id' => null]);
                return response()->json(['success' => true, 'message' => 'Alzas desasignadas exitosamente.']);

            case 'assign':
                HiveSuper::whereIn('id', $hiveSuperIds)->update(['hive_id' => $validatedData['hive_id']]);
                return response()->json(['success' => true, 'message' => 'Alzas asignadas exitosamente.']);
        }

        return response()->json(['success' => false, 'message' => 'Acción no válida.'], 400);
    }
}
