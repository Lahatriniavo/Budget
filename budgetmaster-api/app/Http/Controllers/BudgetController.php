<?php

namespace App\Http\Controllers;

use App\Models\Budget;
use Illuminate\Http\Request;

class BudgetController extends Controller
{
    /**
     * Affiche la liste des budgets de l'utilisateur connecté.
     */
    public function index(Request $request)
    {
        $budgets = $request->user()->budgets()->get();
        return response()->json($budgets);
    }

    /**
     * Enregistre un nouveau budget.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'amount' => 'required|numeric',
            'date' => 'required|date',
            'category' => 'required|string|max:255',
        ]);

        $budget = $request->user()->budgets()->create($request->only('name', 'amount', 'date', 'category'));

        return response()->json($budget, 201);
    }

    /**
     * Affiche un budget spécifique.
     */
    public function show(Request $request, Budget $budget)
    {
        $this->authorize('view', $budget);
        return response()->json($budget);
    }

    /**
     * Met à jour un budget existant.
     */
    public function update(Request $request, Budget $budget)
    {
        $this->authorize('update', $budget);

        $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'amount' => 'sometimes|required|numeric',
            'date' => 'sometimes|required|date',
            'category' => 'sometimes|required|string|max:255',
        ]);

        $budget->update($request->only('name', 'amount', 'date', 'category'));

        return response()->json($budget);
    }

    /**
     * Supprime un budget.
     */
    public function destroy(Request $request, Budget $budget)
    {
        $this->authorize('delete', $budget); // ← nécessaire pour protéger la suppression

        $budget->delete();

        return response()->json(null, 204);
    }
}
