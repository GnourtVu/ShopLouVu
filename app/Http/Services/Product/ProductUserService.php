<?php

namespace App\Http\Services\Product;

use App\Models\Product;

class ProductUserService
{
    const LIMIT = 16;
    public function get($page = null)
    {
        return  Product::select('id', 'name', 'price', 'price_sale', 'thumb')->where('active', 1)
            ->orderByDesc('id')->when($page != null, function ($query) use ($page) {
                $query->offset($page * self::LIMIT);
            })->limit(self::LIMIT)->get();
    }
    public function showProductById($id)
    {
        return Product::where('id', $id)
            ->where('active', 1)
            ->with('menu')
            ->firstOrFail();
    }
    public function moreProduct($id)
    {
        return Product::select('id', 'name', 'price', 'price_sale', 'thumb')->where('active', 1)
            ->where('id', '!=', $id)
            ->orderByDesc('id')->limit(8)->get();
    }
}
