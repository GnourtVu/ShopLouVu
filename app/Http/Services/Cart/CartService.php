<?php

namespace App\Http\Services\Cart;

use App\Models\Product;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Session;

class CartService
{
    public function create($request): bool
    {
        $qty = (int)$request->input('num_product');
        $product_id = (int)$request->input('product_id');

        if ($qty <= 0 || $product_id <= 0) {
            Session::flash('error', 'Quantity or product is not correct');
            return false;
        }

        $carts = Session::get('carts', []);

        if (Arr::exists($carts, $product_id)) {
            // Cập nhật số lượng sản phẩm hiện có
            $carts[$product_id] += $qty;
        } else {
            // Thêm sản phẩm mới vào giỏ hàng
            $carts[$product_id] = $qty;
        }

        // Cập nhật session với giỏ hàng mới
        Session::put('carts', $carts);
        return true;
    }

    public function getProduct()
    {
        $carts = Session::get('carts', []);

        if (empty($carts)) {
            return [];
        }

        $product_id = array_keys($carts);

        return Product::select('id', 'name', 'price', 'price_sale', 'thumb')
            ->where('active', 1)
            ->whereIn('id', $product_id)
            ->get();
    }
}
