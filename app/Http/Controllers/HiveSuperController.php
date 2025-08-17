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
    public function index()
    {
        $hiveSupers = HiveSuper::with('hive')->get();
        $total = $hiveSupers->count();
        $assigned = $hiveSupers->whereNotNull('hive_id')->count();
        $unassigned = $total - $assigned;

        return view('hive_supers.index', compact('hiveSupers', 'total', 'assigned', 'unassigned'));
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
}
