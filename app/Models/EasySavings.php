<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EasySavings extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'amount',
        'start_date',
        'savings_frequency_id',
        'savings_duration_id',
        'end_of_savings_date',
        'last_date_debited',
        'total_amount_to_be_debited',
        'total_amount_debited_so_far',
        'defaulted',
        'disbursed',
        'amount_disbursed',
        'date_disbursed',
        'cause_of_disbursement',
    ];  

    public function debitHistory(){
        return $this->hasMany(SavingHistory::class);
    }
}
