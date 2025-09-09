<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\FinancialGoal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class FinancialGoalController extends Controller
{
    // Liste des objectifs pour l'utilisateur connecté
    public function index()
    {
        $user = Auth::user();
        $goals = FinancialGoal::where('user_id', $user->id)->get();
        return response()->json($goals);
    }

    // Créer un nouvel objectif
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'target_amount' => 'required|numeric|min:0',
            'deadline' => 'nullable|date',
            'category' => ['nullable', Rule::in(['Logement', 'Transport', 'Alimentation', 'Divertissement', 'Autres'])],
            'saved_amount' => 'nullable|numeric|min:0',
        ]);

        $goal = FinancialGoal::create([
            'user_id' => Auth::id(),
            'name' => $request->name,
            'target_amount' => $request->target_amount,
            'deadline' => $request->deadline,
            'category' => $request->category,
            'saved_amount' => $request->saved_amount ?? 0,
        ]);

        return response()->json($goal, 201);
    }

    // Mettre à jour un objectif
    public function update(Request $request, $id)
    {
        $goal = FinancialGoal::where('id', $id)->where('user_id', Auth::id())->firstOrFail();

        $request->validate([
            'name' => 'required|string|max:255',
            'target_amount' => 'required|numeric|min:0',
            'deadline' => 'nullable|date',
            'category' => ['nullable', Rule::in(['Logement', 'Transport', 'Alimentation', 'Divertissement', 'Autres'])],
            'saved_amount' => 'nullable|numeric|min:0',
        ]);

        $goal->update($request->only(['name', 'target_amount', 'deadline', 'category', 'saved_amount']));

        return response()->json($goal);
    }

    // Supprimer un objectif
    public function destroy($id)
    {
        $goal = FinancialGoal::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        $goal->delete();

        return response()->json(null, 204);
    }
}
