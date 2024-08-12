<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SavingHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'easy_savings_id',
        'amount',
    ];
}
