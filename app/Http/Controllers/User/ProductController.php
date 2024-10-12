<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Services\Product\ProductUserService;
use App\Http\Services\Menu\MenuService;
use Illuminate\Support\Facades\Session;
use App\Http\Services\Cart\CartService;
use App\Models\Cart;
use App\Models\Color;
use App\Models\Customer;
use App\Models\Message;
use App\Models\Product;
use App\Models\Product_var;
use App\Models\Review;
use App\Models\Size;
use Illuminate\Support\Facades\DB;

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

        // Kiểm tra xem có review nào với rating = 5 không
        $rv = Review::Where('product_id', $productDt->id)->first();
        $rvList = Review::Where('product_id', $productDt->id)->get();
        $rvCount = Review::Where('product_id', $productDt->id)->count();
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
        // Khởi tạo giá trị ban đầu cho customerRv
        $customerRv = null;

        // Nếu có $rv thì mới lấy customer
        if ($rv) {
            $customerRv = Customer::where('id', $rv->customer_id)->first();
        }

        $allRv = Review::where('product_id', $productDt->id)->get();
        $star = 0;
        $starTb = 0;

        if ($rvCount > 0) {
            foreach ($allRv as $rvItem) {
                $star += $rvItem->rating;
            }
            $starTb = $star / $rvCount;
        }

        return view('user.contentProduct', [
            'title' => 'Content Product',
            'productDt' => $productDt,
            'menus' => $this->menuService->show(),
            'productss' => $productss,
            'products' => $products,
            'rvCount' => $rvCount,
            'colors' => Color::all(),
            'sizes' => Size::all(),
            'customerRl' => Session::get('customerRole'),
            'customerRv' => $customerRv,
            'rv' => $rv,
            'starTb' => $starTb,
            'rvList' => $rvList,
            'carts' => $cartItems,
            'countCart' => $countCart
        ]);
    }
    public function getProductQuantityByName(Request $request)
    {
        // Lấy thông tin từ request
        $productId = $request->input('product_id');
        $colorName = $request->input('color_name');
        $sizeName = $request->input('size_name');

        // Tìm Color và Size dựa trên name (trong bảng colors và sizes)
        $color = Color::where('name', $colorName)->first();
        $size = Size::where('name', $sizeName)->first();

        // Kiểm tra xem cả color và size có tồn tại không
        if ($color && $size) {
            // Truy vấn product_var để lấy số lượng dựa trên product_id, size_id và color_id
            $productVar = Product_var::where('product_id', $productId)
                ->where('size_id', $size->id)  // Lấy size_id
                ->where('color_id', $color->id) // Lấy color_id
                ->first();

            // Nếu tìm thấy bản ghi trong product_var
            if ($productVar) {
                return response()->json(['qty' => $productVar->qty]); // Trả về số lượng sản phẩm
            }
        }

        // Nếu không tìm thấy, trả về số lượng là 0
        return response()->json(['qty' => 0]);
    }


    public function search(Request $request)
    {
        $search = $request->input('search');
        $messages = Message::select('email', 'content')->orderByDesc('id')->get();
        $msCount = Message::count();
        // Tách chuỗi tìm kiếm thành mảng từ khóa (các từ cách nhau bởi khoảng trắng)
        $keywords = explode(' ', $search);

        // Tìm kiếm sản phẩm theo tất cả từ khóa trong tên hoặc theo ID
        $products = Product::select(
            'products.id',
            'products.name',
            'products.price',
            'products.price_sale',
            'products.thumb',
            'products.qty_stock',
            'products.image1',
            'products.image2',
            'products.image3',
            'products.updated_at',
            DB::raw('IFNULL(SUM(order_items.qty), 0) as total_qty') // Nếu không có giá trị, đặt mặc định là 0
        )
            ->leftJoin('order_items', 'products.id', '=', 'order_items.product_id') // Sử dụng LEFT JOIN để lấy cả sản phẩm chưa được bán
            ->where('products.active', 1)
            ->groupBy('products.id', 'products.updated_at', 'products.name', 'products.price', 'products.price_sale', 'products.thumb', 'products.qty_stock', 'products.image1', 'products.image2', 'products.image3') // Nhóm theo các cột không phải hàm tổng hợp
            ->where(function ($query) use ($keywords) {
                foreach ($keywords as $keyword) {
                    $query->where('products.name', 'LIKE', "%{$keyword}%");
                }
            })
            ->orWhere('products.id', $search)  // Tìm kiếm theo ID chính xác
            ->paginate(20);

        return view('admin.products.list', [
            'title' => 'Search product',
            'products' => $products,
            'messages' => $messages,
            'msCount' => $msCount,
        ]);
    }
    public function searchUser(Request $request)
    {
        // Lấy sản phẩm từ getmainProducts
        $productss = $this->menuService->getmainProducts($request);

        $search = $request->input('search');
        $keywords = explode(' ', $search);

        // Tìm kiếm sản phẩm theo tất cả từ khóa trong tên hoặc theo ID
        $productss = $productss->where(function ($query) use ($keywords) {
            foreach ($keywords as $keyword) {
                $query->where('products.name', 'LIKE', "%{$keyword}%");
            }
        })->orWhere('products.id', $search);

        // Thực thi truy vấn và phân trang
        $productss = $productss->paginate(16)->withQueryString();

        // Các sản phẩm trong giỏ hàng
        $products = $this->cartService->getProduct();

        // Tổng số sản phẩm
        $totalProducts = Product::count();
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
        return view('user.shop', [
            'title' => 'Shop LouVu',
            'menus' => $this->menuService->show(),
            'productss' => $productss,
            'products' => $products,
            'carts' => $cartItems,
            'totalProducts' => $totalProducts,
            'countCart' => $countCart
        ]);
    }
}
