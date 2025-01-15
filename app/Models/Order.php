<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'total_price',
        'shipping_address',
        'status',
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function shippings() {
        return $this->hasOne(Shipping::class);
    }

    public function items() {
        return $this->hasMany(OrderItem::class);
    }

    public function payment() {
        return $this->hasOne(Payment::class);
    }
}
