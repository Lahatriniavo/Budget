<?php

namespace App\Imports;

use App\Models\Transaction;
use Maatwebsite\Excel\Concerns\ToModel;

class TransactionsImport implements ToModel
{
    public function model(array $row)
    {
        return new Transaction([
            'user_id' => auth()->id(),
            'amount' => $row[0],
            'category' => $row[1],
            'date' => $row[2],
        ]);
    }
}

