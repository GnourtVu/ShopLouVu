<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Services\Menu\MenuService;

class MenuController extends Controller
{
    //
    protected $menuService;
    public function __construct(MenuService $menuService)
    {
        $this->menuService = $menuService;
    }
    public function index(Request $request, $id, $name)
    {
        $menu = $this->menuService->getId($id);
        $menus = $this->menuService->getMenu();
        $products = $this->menuService->getProducts($menu, $request);
        return view('user.categoriesProduct', [
            'title' => $menu->name,
            'products' => $products,
            'menu' => $menu,
            'menus' => $menus
        ]);
    }
}
