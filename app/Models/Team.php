<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
class Team extends Model
{
    protected $fillable = ['name', 'description'];

    public function users()
    {
        return $this->hasMany(User::class);
    }
}
