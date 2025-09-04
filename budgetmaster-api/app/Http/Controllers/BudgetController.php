<?php

namespace App\Http\Controllers;

use App\Models\Budget;
use Illuminate\Http\Request;

class BudgetController extends Controller
{
    public function index(Request $request)
    {
        // Lister les budgets de l’utilisateur connecté
        $budgets = $request->user()->budgets()->get();
        return response()->json($budgets);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'amount' => 'required|numeric',
        ]);

        $budget = $request->user()->budgets()->create($request->only('name', 'amount'));

        return response()->json($budget, 201);
    }

    public function show(Request $request, Budget $budget)
    {
        // Vérifier que le budget appartient à l’utilisateur
        $this->authorize('view', $budget);
        return response()->json($budget);
    }

    public function update(Request $request, Budget $budget)
    {
        $this->authorize('update', $budget);

        $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'amount' => 'sometimes|required|numeric',
        ]);

        $budget->update($request->only('name', 'amount'));

        return response()->json($budget);
    }

    public function destroy(Budget $budget)
    {
        $this->authorize('delete', $budget);
        $budget->delete();
        return response()->json(null, 204);
    }
}
