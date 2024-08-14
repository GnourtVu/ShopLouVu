<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Services\Product\ProductUserService;
use App\Http\Services\Slider\SliderService;
use Illuminate\Http\Request;
use App\Http\Services\Menu\MenuService;
use Illuminate\Support\Facades\Session;
use App\Http\Services\Cart\CartService;

class MainController extends Controller
{
    //
    protected $menuService;
    protected $cartService;
    protected $slider;
    protected $productService;
    public function __construct(MenuService $menuService, SliderService $slider, ProductUserService $productService, CartService $cartService)
    {
        $this->menuService = $menuService;
        $this->slider = $slider;
        $this->productService = $productService;
        $this->cartService = $cartService;
    }
    public function index()
    {
        $products = $this->cartService->getProduct();
        return view('user.homeProduct', [
            'title' => 'LouVu Fashion',
            'sliders' => $this->slider->show(),
            'menus' => $this->menuService->show(),
            'products' => $products,
            'carts' => Session::get('carts'),
        ]);
    }
    public function product()
    {
        $products = $this->cartService->getProduct();
        return view('user.shop', [
            'title' => 'Shop LouVu',
            'menus' => $this->menuService->show(),
            'productss' => $this->productService->get(),
            'products' => $products,
            'carts' => Session::get('carts'),
        ]);
    }
    public function loadProduct(Request $request)
    {
        $page = $request->input('page', 0);
        $result = $this->productService->get($page);
        if (count($result) != 0) {
            $html = view('user.product', ['productss' => $result])->render();
            return response()->json(['html' => $html]);
        }
        return response()->json(['html' => '']);
    }
    public function contact()
    {
        $products = $this->cartService->getProduct();
        return view(
            'user.contact',
            [
                'title' => 'Contact',
                'menus' => $this->menuService->show(),
                'products' => $products,
                'carts' => Session::get('carts'),
            ]
        );
    }
    public function about()
    {
        $products = $this->cartService->getProduct();
        return view(
            'user.about',
            [
                'title' => 'About',
                'menus' => $this->menuService->show(),
                'products' => $products,
                'carts' => Session::get('carts'),
            ]
        );
    }
}
