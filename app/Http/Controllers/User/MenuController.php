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
    public function index(Request $request, $id, $slug)
    {
        // Lấy danh mục theo id
        $menu = $this->menuService->getId($id);

        // Kiểm tra nếu không tìm thấy danh mục
        if (!$menu) {
            abort(404);
        }

        // Kiểm tra tính hợp lệ của slug
        if ($menu->slug !== $slug) {
            return redirect()->route('categories.show', ['id' => $menu->id, 'slug' => $menu->slug], 301);
        }

        $products = $this->cartService->getProduct();
        $menus = $this->menuService->show();
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
