<?php

namespace App\Http\Services\Product;

use App\Models\Product;
use Illuminate\Support\Facades\DB;

class ProductUserService
{
    const LIMIT = 16; // Số sản phẩm mỗi trang

    public function get($page = null)
    {
        return Product::select('id', 'name', 'price', 'price_sale', 'thumb')
            ->where('active', 1)
            // ->orderByDesc('id')
            ->when($page != null, function ($query) use ($page) {
                $query->offset($page * self::LIMIT); // Tính toán offset dựa trên trang
            })
            ->limit(self::LIMIT)
            ->get();
    }

    public function showProductById($id)
    {
        return Product::select(
            'products.id',
            'products.name',
            'products.price',
            'products.description',
            'products.content',
            'products.menu_id',
            'products.price_sale',
            'products.thumb',
            'products.qty_stock',
            'products.image1',
            'products.image2',
            'products.image3',
            DB::raw('IFNULL(SUM(order_items.qty), 0) as total_qty') // Nếu không có giá trị, đặt mặc định là 0
        )
            ->leftJoin('order_items', 'products.id', '=', 'order_items.product_id') // Sử dụng LEFT JOIN để lấy cả sản phẩm chưa được bán
            ->where('products.active', 1)
            ->groupBy(
                'products.description',
                'products.content',
                'products.menu_id',
                'products.id',
                'products.name',
                'products.price',
                'products.price_sale',
                'products.thumb',
                'products.qty_stock',
                'products.image1',
                'products.image2',
                'products.image3'
            )->where('products.id', $id)
            ->with('menu')
            ->firstOrFail();
    }
    public function moreProduct($id)
    {
        $currentProduct = $this->showProductById($id);
        $menu_id = $currentProduct->menu_id;
        return Product::select(
            'products.id',
            'products.name',
            'products.price',
            'products.description',
            'products.content',
            'products.menu_id',
            'products.price_sale',
            'products.thumb',
            'products.qty_stock',
            'products.image1',
            'products.image2',
            'products.image3',
            DB::raw('IFNULL(SUM(order_items.qty), 0) as total_qty') // Nếu không có giá trị, đặt mặc định là 0
        )
            ->leftJoin('order_items', 'products.id', '=', 'order_items.product_id') // Sử dụng LEFT JOIN để lấy cả sản phẩm chưa được bán
            ->where('products.active', 1)
            ->groupBy(
                'products.description',
                'products.content',
                'products.menu_id',
                'products.id',
                'products.name',
                'products.price',
                'products.price_sale',
                'products.thumb',
                'products.qty_stock',
                'products.image1',
                'products.image2',
                'products.image3'
            )
            ->where('products.id', '!=', $id)->where('products.menu_id', $menu_id)
            ->orderByDesc('products.id')->limit(8)->get();
    }
    public function getProductHotSale()
    {
        return Product::with('orderItems')
            ->select('products.id', 'products.name', 'products.price', 'products.thumb', DB::raw('SUM(order_items.qty) as total_qty'))
            ->join('order_items', 'products.id', '=', 'order_items.product_id')
            ->groupBy('products.id', 'products.name', 'products.price', 'products.thumb')
            ->orderBy('total_qty', 'desc')
            ->take(12)
            ->get();
    }
}
