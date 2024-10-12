<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Product\ProductRequest;
use App\Http\Services\Menu\MenuService;
use App\Http\Services\Product\ProductService;
use App\Models\Color;
use App\Models\Product;
use Illuminate\Contracts\Session\Session;
use Illuminate\Contracts\Support\Jsonable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\Menu;
use App\Models\Message;
use App\Models\Size;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    protected $menuService;
    protected $productService;
    public function __construct(MenuService $menuService, ProductService $productService)
    {
        $this->menuService = $menuService;
        $this->productService = $productService;
    }
    // Danh sách sản phẩm
    public function index()
    {
        //
        $messages = Message::select('email', 'content')->orderByDesc('id')->get();
        $msCount = Message::count();
        return view('admin.products.list', [
            'title' => 'List Products',
            'messages' => $messages,
            'msCount' => $msCount,
            'products' => $this->productService->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $messages = Message::select('email', 'content')->orderByDesc('id')->get();
        $msCount = Message::count();
        $sizes = Size::get();
        $colors = Color::get();
        return view('admin.products.create', [
            'title' => 'Create Product',
            'messages' => $messages,
            'colors' => $colors,
            'sizes' => $sizes,
            'msCount' => $msCount,
            'menus' => $this->productService->getMenu()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductRequest $request)
    {
        //
        $result = $this->productService->create($request);
        if ($result) {
            return redirect('/admin/products/index')->with('success', 'Create product is successful');
        } else {
            return redirect()->back()->with('error', 'Can not create proudct');
        }
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ProductRequest $request, Product $product)
    {
        $result = $this->productService->getProduct($request, $product);
        if ($result) {
            return redirect('/admin/products/index');
        } else {
            return redirect()->back();
        }
    }
    public function show(Menu $menu, Product $product)
    {
        $quantities = $product->getQuantitiesBySizeAndColor();
        $messages = Message::select('email', 'content')->orderByDesc('id')->get();
        $msCount = Message::count();
        $colors = Color::all();
        $sizes = Size::all();
        return view('admin.products.edit', [
            'title' => 'Edit product',
            'product' => $product,
            'messages' => $messages,
            'msCount' => $msCount,
            'menu' => $menu,
            'sizes' => $sizes,
            'colors' => $colors,
            'menus' => $this->productService->getMenu(),
            'quantities' => $quantities
        ]);
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request): JsonResponse
    {
        //
        $result = $this->productService->destroy($request);
        if ($result) {
            return response()->json([
                'error' => false,
                'message' => 'Delete successful'
            ]);
        } else {
            return response()->json([
                'error' => true,
                'message' => 'Delete failed'
            ]);
        }
    }
}
