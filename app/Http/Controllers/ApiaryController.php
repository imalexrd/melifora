<?php

namespace App\Http\Controllers;

use App\Models\Apiary;
use Illuminate\Http\Request;

class ApiaryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $apiaries = Apiary::latest()->paginate(10);
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

        return redirect()->route('apiaries.index')->with('success', 'Apiary created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Apiary $apiary)
    {
        return view('apiaries.show', compact('apiary'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Apiary $apiary)
    {
        return view('apiaries.edit', compact('apiary'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Apiary $apiary)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
        ]);

        $apiary->update($validatedData);

        return redirect()->route('apiaries.index')->with('success', 'Apiary updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Apiary $apiary)
    {
        $apiary->delete();

        return redirect()->route('apiaries.index')->with('success', 'Apiary deleted successfully.');
    }
}
