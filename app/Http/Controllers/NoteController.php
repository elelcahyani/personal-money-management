<?php

namespace App\Http\Controllers;

use App\Models\Note;
use Illuminate\Http\Request;

class NoteController extends Controller
{
    public function index()
    {
        /** @var \App\Models\User $user */
        $user = auth()->user();
        $notes = Note::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();
            
        return view('notes.index', compact('notes'));
    }

    public function create()
    {
        return view('notes.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        /** @var \App\Models\User $user */
        $user = auth()->user();
        $validated['user_id'] = $user->id;
        Note::create($validated);

        return redirect()->route('notes.index')->with('success', 'Catatan berhasil ditambahkan!');
    }

    public function edit(Note $note)
    {
        /** @var \App\Models\User $user */
        $user = auth()->user();
        if ($note->user_id !== $user->id) {
            abort(403);
        }
        
        return view('notes.edit', compact('note'));
    }

    public function update(Request $request, Note $note)
    {
        /** @var \App\Models\User $user */
        $user = auth()->user();
        if ($note->user_id !== $user->id) {
            abort(403);
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        $note->update($validated);

        return redirect()->route('notes.index')->with('success', 'Catatan berhasil diupdate!');
    }

    public function destroy(Note $note)
    {
        /** @var \App\Models\User $user */
        $user = auth()->user();
        if ($note->user_id !== $user->id) {
            abort(403);
        }

        $note->delete();

        return redirect()->route('notes.index')->with('success', 'Catatan berhasil dihapus!');
    }
}
