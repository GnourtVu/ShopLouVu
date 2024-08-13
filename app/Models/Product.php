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
        'image3'
    ];
    public function menu()
    {
        return $this->hasOne(Menu::class, 'id', 'menu_id')->withDefault(['name' => '']);
    }
    public function product_images()
    {
        return $this->hasMany(ProductImages::class, 'product_id', 'id');
    }
}
