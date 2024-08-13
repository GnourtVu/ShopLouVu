<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;
    protected $fillable = [
        'customer_id',
        'product_id',
        'pty',
        'price'
    ];
    public function product()
    {
        return $this->hasMany(Product::class, 'id', 'product_id');
    }
    public function customer()
    {
        return $this->hasOne(Customer::class, 'customer_id', 'id');
    }
}
