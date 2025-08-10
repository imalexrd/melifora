<?php

namespace App\Http\Controllers;

use App\Models\Hive;
use App\Models\HiveNote;
use Illuminate\Http\Request;

class HiveNoteController extends Controller
{
    public function store(Request $request, Hive $hive)
    {
        $request->validate(['content' => 'required|string']);

        $note = $hive->notes()->create([
            'user_id' => auth()->id(),
            'content' => $request->content,
        ]);

        $note->load('user');

        return response()->json($note);
    }

    public function update(Request $request, Hive $hive, HiveNote $note)
    {
        if ($note->user_id !== auth()->id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $request->validate(['content' => 'required|string']);

        $note->update(['content' => $request->content]);

        $note->load('user');

        return response()->json($note);
    }

    public function destroy(Hive $hive, HiveNote $note)
    {
        if ($note->user_id !== auth()->id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $note->delete();

        return response()->json(['success' => true]);
    }
}
