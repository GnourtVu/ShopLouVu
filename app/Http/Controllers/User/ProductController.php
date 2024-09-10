<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Services\Product\ProductUserService;
use App\Http\Services\Menu\MenuService;
use Illuminate\Support\Facades\Session;
use App\Http\Services\Cart\CartService;

class ProductController extends Controller
{
    //
    protected $productService;
    protected $cartService;
    protected $menuService;
    public function __construct(ProductUserService $productService, MenuService $menuService, CartService $cartService)
    {
        $this->productService = $productService;
        $this->menuService = $menuService;
        $this->cartService = $cartService;
    }
    public function index($id = '')
    {
        $products = $this->cartService->getProduct();
        $productDt = $this->productService->showProductById($id);
        $productss = $this->productService->moreProduct($id);
        return view('user.contentProduct', [
            'title' => 'Content Product',
            'productDt' => $productDt,
            'menus' => $this->menuService->show(),
            'productss' => $productss,
            'products' => $products,
            'carts' => Session::get('carts')
        ]);
    }
}
