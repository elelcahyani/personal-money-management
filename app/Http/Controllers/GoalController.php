<?php

namespace App\Http\Controllers;

use App\Models\Goal;
use Illuminate\Http\Request;

class GoalController extends Controller
{
    public function index()
    {
        /** @var \App\Models\User $user */
        $user = auth()->user();
        $goals = Goal::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();
            
        return view('goals.index', compact('goals'));
    }

    public function create()
    {
        return view('goals.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'target_amount' => 'required|numeric|min:0',
            'target_date' => 'nullable|date',
        ]);

        /** @var \App\Models\User $user */
        $user = auth()->user();
        $validated['user_id'] = $user->id;
        Goal::create($validated);

        return redirect()->route('goals.index')->with('success', 'Goal berhasil ditambahkan!');
    }

    public function edit(Goal $goal)
    {
        /** @var \App\Models\User $user */
        $user = auth()->user();
        if ($goal->user_id !== $user->id) {
            abort(403);
        }
        
        return view('goals.edit', compact('goal'));
    }

    public function update(Request $request, Goal $goal)
    {
        /** @var \App\Models\User $user */
        $user = auth()->user();
        if ($goal->user_id !== $user->id) {
            abort(403);
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'target_amount' => 'required|numeric|min:0',
            'current_amount' => 'required|numeric|min:0',
            'target_date' => 'nullable|date',
            'status' => 'required|in:active,completed,cancelled',
        ]);

        $goal->update($validated);

        return redirect()->route('goals.index')->with('success', 'Goal berhasil diupdate!');
    }

    public function destroy(Goal $goal)
    {
        /** @var \App\Models\User $user */
        $user = auth()->user();
        if ($goal->user_id !== $user->id) {
            abort(403);
        }

        $goal->delete();

        return redirect()->route('goals.index')->with('success', 'Goal berhasil dihapus!');
    }
}
