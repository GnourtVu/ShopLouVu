<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Services\Product\ProductUserService;
use App\Http\Services\Menu\MenuService;

class ProductController extends Controller
{
    //
    protected $productService;
    protected $menuService;
    public function __construct(ProductUserService $productService, MenuService $menuService)
    {
        $this->productService = $productService;
        $this->menuService = $menuService;
    }
    public function index($id = '', $name = '')
    {
        $product = $this->productService->showProductById($id);
        $products = $this->productService->moreProduct($id);
        return view('user.contentProduct', [
            'title' => 'Content Product',
            'product' => $product,
            'menus' => $this->menuService->show(),
            'products' => $products
        ]);
    }
}
