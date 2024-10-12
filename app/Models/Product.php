<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'description',
        'content',
        'price',
        'price_sale',
        'menu_id',
        'active',
        'thumb',
        'image1',
        'image2',
        'image3',
        'qty_stock',
        'feedback',
        'size'
    ];
    public function getQuantitiesBySizeAndColor()
    {
        $quantities = [];
        foreach ($this->quantities as $quantity) {
            $quantities[$quantity->size_id][$quantity->color_id] = $quantity->qty;
        }
        return $quantities;
    }
    public function menu()
    {
        return $this->hasOne(Menu::class, 'id', 'menu_id')->withDefault(['name' => '']);
    }
    public function orderItems()
    {
        return $this->hasMany(Order_item::class, 'product_id', 'id');
    }
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
    public function sizes()
    {
        return $this->hasMany(Size::class);
    }
    public function quantities()
    {
        return $this->hasMany(Product_var::class);
    }
}
