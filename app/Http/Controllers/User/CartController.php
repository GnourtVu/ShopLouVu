<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Services\Cart\CartService;
use App\Http\Services\Menu\MenuService;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    //
    protected $cartService;
    protected $menuService;
    public function __construct(CartService $cartService, MenuService $menuService)
    {
        $this->cartService = $cartService;
        $this->menuService = $menuService;
    }
    public function index()
    {
        $products = $this->cartService->getProduct();

        return view('user.cart', [
            'title' => 'Cart List',
            'menus' => $this->menuService->show(),
            'products' => $products,
            'carts' => Session::get('carts')
        ]);
    }
    public function add(Request $request)
    {
        $result = $this->cartService->create($request);
        if ($result === false) {
            return redirect()->back();
        } else {
            return redirect('/cart');
        }
    }
    public function update(Request $request)
    {
        $result = $this->cartService->update($request);
        if ($result === false) {
            return redirect()->back();
        }
        return redirect('/cart');
    }
    public function delete($id = 0)
    {
        $result = $this->cartService->delete($id);
        if ($result === false) {
            return redirect()->back();
        }
        return redirect('/cart');
    }
}
