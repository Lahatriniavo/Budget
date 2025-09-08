<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Forecast;
use Illuminate\Http\Request;

class ForecastController extends Controller
{
    public function index()
    {
        return Forecast::orderBy('month', 'desc')->get();
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'category' => 'required|string',
            'amount' => 'required|numeric|min:0',
            'month' => 'required|date_format:Y-m',
            'type' => 'required|in:revenu,dépense',
        ]);

        $forecast = Forecast::create($validated);
        return response()->json($forecast, 201);
    }

    public function update(Request $request, $id)
    {
        $forecast = Forecast::findOrFail($id);

        $validated = $request->validate([
            'category' => 'required|string',
            'amount' => 'required|numeric|min:0',
            'month' => 'required|date_format:Y-m',
            'type' => 'required|in:revenu,dépense',
        ]);

        $forecast->update($validated);
        return response()->json($forecast);
    }

    public function destroy($id)
    {
        $forecast = Forecast::findOrFail($id);
        $forecast->delete();

        return response()->json(['message' => 'Prévision supprimée avec succès']);
    }
}
