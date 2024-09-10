<?php

namespace App\Http\Services\Product;

use App\Models\Product;
use Illuminate\Support\Facades\DB;

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
        $currentProduct = $this->showProductById($id);
        $menu_id = $currentProduct->menu_id;
        return Product::select('id', 'name', 'price', 'price_sale', 'thumb', 'image1', 'image2', 'image3', 'menu_id')->where('active', 1)
            ->where('id', '!=', $id)->where('menu_id', $menu_id)
            ->orderByDesc('id')->limit(8)->get();
    }
    public function getProductHotSale()
    {
        return Product::join('carts', 'products.id', '=', 'carts.product_id')
            ->select(
                'products.id',
                DB::raw('GROUP_CONCAT(products.name) as name'), // Sử dụng GROUP_CONCAT để lấy tên
                'products.price',
                'products.price_sale',
                'products.thumb',
                'products.image1',
                'products.image2',
                'products.image3',
                DB::raw('SUM(carts.qty) as total_qty') // Tính tổng số lượng bán
            )
            ->groupBy('products.id', 'products.price', 'products.price_sale', 'products.thumb', 'products.image1', 'products.image2', 'products.image3') // Nhóm theo tất cả các trường
            ->orderByDesc('total_qty') // Sắp xếp theo tổng số lượng mua giảm dần
            ->limit(8) // Lấy ra 8 sản phẩm có số lượng mua cao nhất
            ->get();
    }
}
