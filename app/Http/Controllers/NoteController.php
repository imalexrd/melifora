<?php

namespace App\Http\Controllers;

use App\Models\Apiary;
use App\Models\ApiaryNote;
use App\Models\Hive;
use App\Models\HiveNote;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class NoteController extends Controller
{
    /**
     * Store a new note or task for an Apiary.
     */
    public function storeApiaryNote(Request $request, Apiary $apiary)
    {
        return $this->store($request, $apiary);
    }

    /**
     * Update an existing note or task for an Apiary.
     */
    public function updateApiaryNote(Request $request, Apiary $apiary, ApiaryNote $note)
    {
        return $this->update($request, $note);
    }

    /**
     * Delete a note or task for an Apiary.
     */
    public function destroyApiaryNote(Apiary $apiary, ApiaryNote $note)
    {
        return $this->destroy($note);
    }

    /**
     * Store a new note or task for a Hive.
     */
    public function storeHiveNote(Request $request, Hive $hive)
    {
        return $this->store($request, $hive);
    }

    /**
     * Update an existing note or task for a Hive.
     */
    public function updateHiveNote(Request $request, Hive $hive, HiveNote $note)
    {
        return $this->update($request, $note);
    }

    /**
     * Delete a note or task for a Hive.
     */
    public function destroyHiveNote(Hive $hive, HiveNote $note)
    {
        return $this->destroy($note);
    }

    /**
     * Generic method to store a note or task for a noteable model.
     */
    private function store(Request $request, $noteable)
    {
        $validatedData = $request->validate([
            'content' => 'required|string',
            'type' => ['required', Rule::in(['note', 'task'])],
            'due_date' => 'nullable|date|required_if:type,task',
        ]);

        $note = $noteable->notes()->create([
            'user_id' => auth()->id(),
            'content' => $validatedData['content'],
            'type' => $validatedData['type'],
            'due_date' => $validatedData['due_date'] ?? null,
        ]);

        $note->load('user');

        return response()->json($note);
    }

    /**
     * Generic method to update a note or task.
     */
    private function update(Request $request, $note)
    {
        if ($note->user_id !== auth()->id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $validatedData = $request->validate([
            'content' => 'required|string',
            'type' => ['required', Rule::in(['note', 'task'])],
            'due_date' => 'nullable|date|required_if:type,task',
        ]);

        // If the 'completed' flag is sent, set the completed_at timestamp
        if ($request->has('completed')) {
            $validatedData['completed_at'] = $request->input('completed') ? now() : null;
        }

        $note->update($validatedData);

        $note->load('user');

        return response()->json($note);
    }

    /**
     * Generic method to delete a note or task.
     */
    private function destroy($note)
    {
        if ($note->user_id !== auth()->id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $note->delete();

        return response()->json(['success' => true]);
    }
}
