<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = auth()->user();
        
        $query = Transaction::where('user_id', $user->id);
        
        // Filter by date range
        if ($request->filled('start_date')) {
            $query->whereDate('transaction_date', '>=', $request->start_date);
        }
        
        if ($request->filled('end_date')) {
            $query->whereDate('transaction_date', '<=', $request->end_date);
        }
        
        // Filter by type
        if ($request->filled('type') && $request->type !== 'all') {
            $query->where('type', $request->type);
        }
        
        // Filter by category
        if ($request->filled('category')) {
            $query->where('category', 'like', '%' . $request->category . '%');
        }
        
        $transactions = $query->orderBy('transaction_date', 'desc')->paginate(10);
        
        return view('transactions.index', compact('transactions'));
    }

    public function create()
    {
        return view('transactions.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'type' => 'required|in:income,expense',
            'amount' => 'required|numeric|min:0',
            'category' => 'required|string|max:255',
            'description' => 'nullable|string',
            'transaction_date' => 'required|date',
        ]);

        /** @var \App\Models\User $user */
        $user = auth()->user();
        $validated['user_id'] = $user->id;
        Transaction::create($validated);

        return redirect()->route('transactions.index')->with('success', 'Transaksi berhasil ditambahkan!');
    }

    public function edit(Transaction $transaction)
    {
        /** @var \App\Models\User $user */
        $user = auth()->user();
        if ($transaction->user_id !== $user->id) {
            abort(403);
        }
        
        return view('transactions.edit', compact('transaction'));
    }

    public function update(Request $request, Transaction $transaction)
    {
        /** @var \App\Models\User $user */
        $user = auth()->user();
        if ($transaction->user_id !== $user->id) {
            abort(403);
        }

        $validated = $request->validate([
            'type' => 'required|in:income,expense',
            'amount' => 'required|numeric|min:0',
            'category' => 'required|string|max:255',
            'description' => 'nullable|string',
            'transaction_date' => 'required|date',
        ]);

        $transaction->update($validated);

        return redirect()->route('transactions.index')->with('success', 'Transaksi berhasil diupdate!');
    }

    public function destroy(Transaction $transaction)
    {
        /** @var \App\Models\User $user */
        $user = auth()->user();
        if ($transaction->user_id !== $user->id) {
            abort(403);
        }

        $transaction->delete();

        return redirect()->route('transactions.index')->with('success', 'Transaksi berhasil dihapus!');
    }
}
