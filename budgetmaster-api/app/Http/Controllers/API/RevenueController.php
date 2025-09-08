<?php

// app/Http/Controllers/API/RevenueController.php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Revenue;
use Illuminate\Support\Facades\Auth;

class RevenueController extends Controller
{
    public function index()
    {
        return Revenue::where('user_id', Auth::id())->orderBy('date', 'desc')->get();
    }

    public function store(Request $request)
    {
        $request->validate([
            'source' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'date' => 'required|date',
        ]);

        return Revenue::create([
            'source' => $request->source,
            'amount' => $request->amount,
            'date' => $request->date,
            'user_id' => Auth::id(),
        ]);
    }

    public function update(Request $request, $id)
    {
        $revenue = Revenue::where('id', $id)->where('user_id', Auth::id())->firstOrFail();

        $request->validate([
            'source' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'date' => 'required|date',
        ]);

        $revenue->update($request->only(['source', 'amount', 'date']));

        return $revenue;
    }

    public function destroy($id)
    {
        $revenue = Revenue::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        $revenue->delete();

        return response()->json(['message' => 'Revenu supprimé.']);
    }
}

