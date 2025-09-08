<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FinancialGoal extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'target_amount',
        'deadline',
        'category',
        'saved_amount',
    ];

    // Relation vers utilisateur
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
