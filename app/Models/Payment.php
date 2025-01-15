<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'order_id',
        'payment_status',
        'receipt_image',
        'transactions_date',
    ];

    // public function user() {
    //     return $this->belongsTo(User::class);
    // }

    public function order() {
        return $this->belongsTo(Order::class);
    }
}
