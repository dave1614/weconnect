<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecentSearch extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'type',
        'search',
        'searched_user_id',
    ];

    public $appends = ['searched_user', 'deleting_search'];


    public function deletingSearch(): Attribute
    {
        return Attribute::make(
            get: fn () => false
        );
    }

    public function searchedUser(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->type == 'user' ? User::find($this->searched_user_id) : null
        );
    }
}
