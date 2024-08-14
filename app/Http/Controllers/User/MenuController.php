<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Services\Menu\MenuService;
use Illuminate\Support\Facades\Session;
use App\Http\Services\Cart\CartService;

class MenuController extends Controller
{
    //
    protected $menuService;
    protected $cartService;
    public function __construct(MenuService $menuService, CartService $cartService)
    {
        $this->menuService = $menuService;
        $this->cartService = $cartService;
    }
    public function index(Request $request, $id, $name)
    {
        $products = $this->cartService->getProduct();
        $menu = $this->menuService->getId($id);
        $menus = $this->menuService->getMenu();
        $productss = $this->menuService->getProducts($menu, $request);
        return view('user.categoriesProduct', [
            'title' => $menu->name,
            'productss' => $productss,
            'menu' => $menu,
            'menus' => $menus,
            'products' => $products,
            'carts' => Session::get('carts'),
        ]);
    }
}
