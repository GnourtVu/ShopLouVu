<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Order\OrderFormRequest;
use App\Models\Order_item;
use Illuminate\Http\Request;
use App\Http\Services\Cart\CartService;
use App\Http\Services\Menu\MenuService;
use App\Models\Cart;
use App\Models\Discount;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Facades\Log;
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
        $products = $this->cartService->getProduct(); // Lấy danh sách sản phẩm

        // Kiểm tra xem người dùng có đăng nhập không
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


        return view('user.cart', [
            'title' => 'Cart List',
            'menus' => $this->menuService->show(),
            'products' => $products,
            'carts' => $cartItems, // Truyền danh sách sản phẩm trong giỏ hàng cho view
            'countCart' => $countCart,
            'customerPoint' => Session::get('customerRole')
        ]);
    }
    public function point()
    {
        $customer = Session::get('customerRole');

        if ($customer) {
            $point = $customer->point * 100;
        } else {
            $point = 0;
        }
        return back()->with('point', $point);
    }

    public function add(Request $request)
    {
        $result = $this->cartService->create($request);
        if ($result === false) {
            return redirect()->back();
        } else {
            Session::flash('success', 'Thêm vào giỏ hàng thành công');
            return redirect()->back();
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
    public function delete($id, $size, $color)
    {
        $result = $this->cartService->delete($id, $size, $color);

        if ($result === false) {
            return redirect()->back()->with('error', 'Không tìm thấy sản phẩm để xóa.');
        }

        return redirect('/cart')->with('success', 'Xóa sản phẩm thành công.');
    }


    public function buy(OrderFormRequest $request)
    {
        $this->cartService->buy($request);
        return redirect()->back();
    }
    public function order()
    {
        $products = $this->cartService->getProduct();
        $productss = Product::where('name', 'LIKE', '%Áo thun%')->orderByDesc('id')->paginate(16);
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


        return view('user.order', [
            'title' => 'Order View',
            'menus' => $this->menuService->show(),
            'products' => $products,
            'customerRl' => Session::get('customerRole'),
            'productss' => $productss,
            'carts' => $cartItems,
            'countCart' => $countCart
        ]);
    }
    public function apply_discount(Request $request)
    {
        $code = $request->input('code');
        $discount = Discount::where('code', $code)->where('active', 1)->first();
        if ($discount) {
            Session::put('discount', $discount->discount);
            return redirect()->back()->with('success', 'Mã giảm giá được áp dụng');
        } else {
            Session::forget('discount');
            return redirect()->back()->with('error', 'Mã giảm giá không hợp lệ');
        }
    }
    public function viewOd()
    {
        $products = $this->cartService->getProduct();
        if (Session::get('customerRole')) {
            // Lấy giỏ hàng của khách hàng đã đăng nhập và kèm theo thông tin sản phẩm
            $customer = Session::get('customerRole'); // Lấy thông tin khách hàng
            $carts = Cart::where('customer_id', $customer->id)->with('items.product')->first(); // Lấy giỏ hàng với các sản phẩm
            $orders = Order::where('customer_id', $customer->id)->with('order_items')->get();
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
            $orders = null;
            $countCart = count($cartItems); // Đếm số lượng sản phẩm trong giỏ hàng
        }
        return view('user.viewOrder', [
            'title' => 'View order',
            'order' => null,
            'products' => $products,
            'carts' => $cartItems,
            'menus' => $this->menuService->show(),
            'orders' => $orders,
            'countCart' => $countCart
        ]);
    }
    public function findOd(Request $request)
    {
        $products = $this->cartService->getProduct();
        $idCheck = $request->input('orderId');

        // Kiểm tra nếu người dùng chưa nhập mã đơn hàng
        if (empty($idCheck)) {
            Session::flash('error', 'Bạn chưa nhập mã đơn hàng.');
            return redirect()->back();
        }

        $order = Order::where('id', $idCheck)->first();

        // Kiểm tra nếu không tìm thấy đơn hàng
        if (!$order) {
            Session::flash('error', 'Mã đơn hàng không tồn tại. Vui lòng nhập lại!');
            return redirect()->back();
        }
        $orderItem = Order_item::where('order_id', $order->id)->with('product')->get();
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
        // Nếu tìm thấy đơn hàng, trả về view và không có thông báo lỗi
        return view('user.viewOrder', [
            'title' => 'View order',
            'order' => $order,
            'orderItem' => $orderItem,
            'products' => $products,
            'carts' => $cartItems,
            'menus' => $this->menuService->show(),
            'countCart' => $countCart
        ]);
    }
}
