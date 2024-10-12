<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;
    protected $fillable = [
        'customer_id',
    ];
    public $timestamps = false;
    // Model Cart.php
    public function items()
    {
        return $this->hasMany(Cart_Item::class);
    }
}
