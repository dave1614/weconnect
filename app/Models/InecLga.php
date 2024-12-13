<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class InecLga extends Model
{
    use HasFactory;

    public function state(): BelongsTo
    {
        return $this->belongsTo(InecState::class);
    }

    public function wards(): HasMany
    {
        return $this->hasMany(InecWard::class);
    }
}
