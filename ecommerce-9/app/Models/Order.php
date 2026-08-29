<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'order_number',
        'customer_name',
        'customer_phone',
        'customer_address',
        'total_amount',
        'status',
        'payment_method',
        'user_id',
    ];
}
