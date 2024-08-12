<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaystackTransaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'event',
        'transaction_id',
        'domain',
        'status',
        'reference',
        'amount',
        'message',
        'gateway_response',
        'paid_at',
        'created',
        'channel',
        'currency',
        'ip_address',
        'metadata',
        'fees_breakdown',
        'log',
        'fees',
        'fees_split',
        'authorization',
        'customer',
        'source',
    ];
}
