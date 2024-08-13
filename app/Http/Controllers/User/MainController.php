<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Services\Product\ProductUserService;
use App\Http\Services\Slider\SliderService;
use Illuminate\Http\Request;
use App\Http\Services\Menu\MenuService;

class MainController extends Controller
{
    //
    protected $menuService;
    protected $slider;
    protected $productService;
    public function __construct(MenuService $menuService, SliderService $slider, ProductUserService $productService)
    {
        $this->menuService = $menuService;
        $this->slider = $slider;
        $this->productService = $productService;
    }
    public function index()
    {
        return view('user.homeProduct', [
            'title' => 'LouVu Fashion',
            'sliders' => $this->slider->show(),
            'menus' => $this->menuService->show(),
            'products' => $this->productService->get(),
        ]);
    }
    public function product()
    {
        return view('user.shop', [
            'title' => 'Shop LouVu'
        ]);
    }
    public function loadProduct(Request $request)
    {
        $page = $request->input('page', 0);
        $result = $this->productService->get($page);
        if (count($result) != 0) {
            $html = view('user.product', ['products' => $result])->render();
            return response()->json(['html' => $html]);
        }
        return response()->json(['html' => '']);
    }
}
