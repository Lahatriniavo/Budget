<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index()
    {
        return Transaction::orderBy('date', 'desc')->get();
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'description' => 'required|string',
            'amount' => 'required|numeric|min:0',
            'type' => 'required|in:revenu,dépense',
            'date' => 'required|date',
            'category' => 'required|string',
        ]);

        $transaction = Transaction::create($validated);
        return response()->json($transaction, 201);
    }

    public function update(Request $request, $id)
    {
        $transaction = Transaction::findOrFail($id);

        $validated = $request->validate([
            'description' => 'required|string',
            'amount' => 'required|numeric|min:0',
            'type' => 'required|in:revenu,dépense',
            'date' => 'required|date',
            'category' => 'required|string',
        ]);

        $transaction->update($validated);
        return response()->json($transaction);
    }

    public function destroy($id)
    {
        $transaction = Transaction::findOrFail($id);
        $transaction->delete();
        return response()->json(['message' => 'Supprimé avec succès']);
    }
}
