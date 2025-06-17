<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    protected $fillable = ['category_id','name','description','stock','price','image'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function sales()
    {
        return $this->hasMany(Sale::class);
    }

    public function getSalesCountAttribute()
    {
        return $this->sales()->sum('quantity');
    }
    
    //
}
