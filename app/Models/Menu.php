<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    public function roles()
    {
        return $this->hasMany(MenuRole::class);
    }
    //
}
