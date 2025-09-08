<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\TransactionsImport;
use App\Exports\TransactionsExport;

class DataImportExportController extends Controller
{
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:xlsx,csv'
        ]);

        Excel::import(new TransactionsImport, $request->file('file'));

        return response()->json(['message' => 'Importation réussie']);
    }

    public function export()
    {
        return Excel::download(new TransactionsExport, 'transactions.xlsx');
    }
}

