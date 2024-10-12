<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Services\Menu\MenuService;
use Illuminate\Support\Facades\Session;
use App\Http\Services\Cart\CartService;
use App\Models\Cart;
use App\Models\Review;

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
        $menus = $this->menuService->showChild($id);
        $productss = $this->menuService->getProducts($menu, $request);
        $starRatings = []; // Mảng để lưu giá trị sao trung bình cho từng sản phẩm
        foreach ($productss as $product) {
            $star = 0;
            $starTb = 0;
            $rvCount = Review::where('product_id', $product->id)->count();

            if ($rvCount > 0) {
                $star = Review::where('product_id', $product->id)->sum('rating');
                $starTb = $star / $rvCount;
            }

            // Lưu giá trị trung bình sao vào mảng với key là product_id
            $starRatings[$product->id] = $starTb;
        }
        if (Session::get('customerRole')) {
            // Lấy giỏ hàng của khách hàng đã đăng nhập và kèm theo thông tin sản phẩm
            $customer = Session::get('customerRole'); // Lấy thông tin khách hàng
            $carts = Cart::where('customer_id', $customer->id)->with('items.product')->first(); // Lấy giỏ hàng với các sản phẩm

            // Nếu có giỏ hàng
            if ($carts) {
                $cartItems = $carts->items;
                $countCart = count($cartItems); // Sử dụng count thay vì ::count() để đếm số lượng items trong mảng
            } else {
                $cartItems = []; // Nếu không có sản phẩm nào
                $countCart = 0; // Gán giá trị mặc định cho $countCart
            }
        } else {
            // Nếu không có khách hàng, lấy giỏ hàng từ session
            $cartItems = Session::get('carts', []); // Mặc định là một mảng rỗng
            $countCart = count($cartItems); // Đếm số lượng sản phẩm trong giỏ hàng
        }
        return view('user.categoriesProduct', [
            'title' => $menu->name,
            'starRatings' => $starRatings,
            'productss' => $productss,
            'menu' => $menu,
            'menus' => $menus,
            'products' => $products,
            'carts' => $cartItems,
            'countCart' => $countCart
        ]);
    }
}
