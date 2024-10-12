<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'email',
        'phone',
        'password',
        'point',
        'role'
    ];
    public function cart()
    {
        return $this->hasOne(Cart::class, 'customer_id', 'id');
    }
    public function orders()
    {
        return $this->hasMany(Order::class, 'customer_id', 'id');
    }
}
