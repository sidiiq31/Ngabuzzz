<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    //
    protected $fillable = ['invoice_number','car_id','quantity','price_item','total_price','ket','sold_at'];

    public function car()
    {
        return $this->belongsTo(Car::class);
    }
}
