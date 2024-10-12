<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $fillable = [
        'customer_id',
        'payment_method',
        'order_status',
        'total',
        'content',
        'address',
        'discount',
        'province',
        'district',
        'ward'
    ];
    public function order_items()
    {
        return $this->hasMany(Order_item::class, 'order_id', 'id');
    }
}
