<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class InecState extends Model
{
    use HasFactory;

    public function lgas(): HasMany
    {
        return $this->hasMany(InecLga::class);
    }

    public function wards(): HasMany
    {
        return $this->hasMany(InecWard::class);
    }
}
