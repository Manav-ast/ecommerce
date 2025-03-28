<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasFactory, SoftDeletes;

    protected $with = ['orderItems', 'payment', 'user', 'invoice'];

    protected $fillable = ['user_id', 'order_status', 'total_price', 'order_date'];

    protected $casts = [
        'order_date' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }

    public function addresses()
    {
        return $this->hasMany(Address::class);
    }

    public function invoice()
    {
        return $this->hasOne(Invoice::class);
    }
}
