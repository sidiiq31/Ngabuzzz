<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transactions extends Model
{
    protected $table = 'transactions';
    
    protected $fillable = [
        'invoice_number',
        'customer_name',
        'phone',
        'address',
        'total_amount',
        'ket',
        'payment_amount',
    ];
}
