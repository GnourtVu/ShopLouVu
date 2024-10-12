<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Message\MessageFormRequest;
use App\Http\Requests\Order\ReviewFormRequest;
use App\Http\Requests\User\LoginFormRequest;
use App\Http\Requests\User\RegisterFormRequest;
use App\Http\Services\Product\ProductUserService;
use App\Http\Services\Slider\SliderService;
use Illuminate\Http\Request;
use App\Http\Services\Menu\MenuService;
use Illuminate\Support\Facades\Session;
use App\Http\Services\Cart\CartService;
use App\Models\Cart;
use App\Models\Color;
use App\Models\Customer;
use App\Models\Discount;
use App\Models\Message;
use App\Models\Order;
use App\Models\Order_item;
use App\Models\Product;
use App\Models\Review;
use App\Models\Size;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;

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
    public function viewlogin()
    {
        $products = $this->cartService->getProduct();
        return view('user.login', [
            'title' => "Login user",
            'products' => $products,
            'menus' => $this->menuService->show(),
        ]);
    }


    public function login(LoginFormRequest $request)
    {
        $email = $request->input('email');
        $password = $request->input('password');

        // Tìm kiếm khách hàng có vai trò là 1 và email khớp
        $customer = Customer::where('role', 1)->where('email', $email)->first();

        if (!$customer) {
            Session::flash('error', 'Email không tồn tại hoặc không chính xác');
            return redirect()->back();
        }

        // Kiểm tra mật khẩu đã nhập có khớp với mật khẩu đã mã hóa hay không
        if (!Hash::check($password, $customer->password)) {
            Session::flash('error', 'Mật khẩu không chính xác');
            return redirect()->back();
        }
        Session::forget('order');
        Session::forget('total');
        Session::forget('discount');
        // Nếu email và mật khẩu đều khớp, lưu thông tin khách hàng vào session
        Session::put('customerRole', $customer);
        Session::flash('success', 'Đăng nhập thành công . Xin chào, ' . $customer->name . '!');

        return redirect('/user/shop');
    }

    public function viewRegister()
    {
        $products = $this->cartService->getProduct();
        return view('user.register', [
            'title' => "Register user",
            'products' => $products,
            'menus' => $this->menuService->show(),
        ]);
    }
    public function register(RegisterFormRequest $request)
    {
        $name = $request->input('name');
        $email = $request->input('email');
        $password = $request->input('password');
        $passwordCf = $request->input('passwordCf');
        $phone = $request->input('phone');
        $customer = Customer::where('email', $email)->where('phone', $phone)->where('role', 1)->first();
        if ($password !== $passwordCf) {
            Session::flash('error', 'Mật khẩu không khớp.');
            return redirect()->back();
        }
        if ($customer) {
            Session::flash('error', 'Khách hàng đã tồn tại.');
            return redirect()->back();
        }
        $customer = Customer::create([
            'name' => $name,
            'email' => $email,
            'password' => bcrypt($password),
            'phone' => $phone,
            'role' => 1
        ]);
        Session::flash('success', 'Đăng ký thành công.');
        return redirect('user/login');
    }
    public function settings()
    {
        $products = $this->cartService->getProduct();
        $customer = Session::get('customerRole');
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
        return view('user.infor', [
            'title' => "Infor customer",
            'products' => $products,
            'menus' => $this->menuService->show(),
            'customer' => $customer,
            'carts' => $cartItems,
            'countCart' => $countCart
        ]);
    }
    public function updateInfor(RegisterFormRequest $request)
    {
        // Lấy thông tin khách hàng từ session hoặc cơ sở dữ liệu
        $customer = Session::get('customerRole');

        // Tìm khách hàng trong cơ sở dữ liệu dựa trên ID hoặc email
        $customerModel = Customer::find($customer->id);  // Giả sử bảng khách hàng sử dụng model Customer

        $name = $request->input('name');
        $password = $request->input('password');
        $passwordNew = $request->input('passwordNew');
        $passwordCf = $request->input('passwordCf');
        $phone = $request->input('phone');

        // Cập nhật thông tin tên và số điện thoại
        $customerModel->name = $name;
        $customerModel->phone = $phone;

        // Kiểm tra và xử lý đổi mật khẩu
        if (!empty($password) || !empty($passwordNew) || !empty($passwordCf)) {
            // Kiểm tra mật khẩu cũ
            if (!Hash::check($password, $customerModel->password)) {
                Session::flash('error', 'Mật khẩu cũ không đúng.');
                return redirect()->back();
            }

            // Kiểm tra mật khẩu mới và xác nhận
            if ($passwordNew !== $passwordCf) {
                Session::flash('error', 'Mật khẩu không khớp. Vui lòng nhập lại!');
                return redirect()->back();
            }

            // Cập nhật mật khẩu mới
            $customerModel->password = bcrypt($passwordNew);
        }

        // Lưu các thay đổi vào cơ sở dữ liệu
        $customerModel->save();

        // Cập nhật lại session
        Session::put('customerRole', $customerModel);

        Session::flash('success', 'Cập nhật thành công.');
        return redirect()->back();
    }

    public function logout()
    {
        Session::forget('customerRole');
        Session::forget('order');
        Session::forget('total');
        Session::forget('discount');
        Session::flush();
        return redirect()->back();
    }

    public function index()
    {
        $productss = $this->productService->getProductHotSale();
        $products = $this->cartService->getProduct();
        $discountCode = Discount::select('name', 'code', 'id')->where('active', 1)->orderBy('discount', 'asc')->get();
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

        return view('user.homeProduct', [
            'title' => 'LouVu Fashion',
            'sliders' => $this->slider->show(),
            'menus' => $this->menuService->show(),
            'products' => $products,
            'starRatings' => $starRatings,
            'productss' => $productss,
            'discountCode' => $discountCode,
            'countCart' => $countCart,
            'carts' => $cartItems,
        ]);
    }
    public function quickView($id, Request $request)
    {
        $product = Product::find($id);
        if (!$product) {
            return response()->json(['error' => 'Product not found'], 404);
        }

        // Lấy size và color từ request
        $size = $request->get('size');
        $color = $request->get('color');

        // Nếu không có size hoặc color, trả về thông tin sản phẩm cơ bản
        if (!$size || !$color) {
            return response()->json([
                'id' => $product->id,
                'name' => $product->name,
                'price' => $product->price,
                'description' => $product->description,
                'qty_stock' => $product->qty_stock,
                'thumb' => $product->thumb,
                'image1' => $product->image1,
                'image2' => $product->image2,
                'image3' => $product->image3
            ]);
        }

        // Truy xuất thông tin về sản phẩm theo size và color
        $productVar = DB::table('product_vars')
            ->where('product_id', $id)
            ->where('size', $size)
            ->where('color', $color)
            ->first();

        // Kiểm tra nếu productVar tồn tại
        if (!$productVar) {
            return response()->json(['error' => 'Product variation not found'], 404);
        }

        // Trả về thông tin sản phẩm bao gồm cả số lượng còn lại
        return response()->json([
            'id' => $product->id,
            'name' => $product->name,
            'price' => $product->price,
            'description' => $product->description,
            'qty' => $productVar->qty, // Số lượng sản phẩm với size và color đã chọn
            'qty_stock' => $product->qty_stock,
            'thumb' => $product->thumb,
            'image1' => $product->image1,
            'image2' => $product->image2,
            'image3' => $product->image3
        ]);
    }



    // public function show($id)
    // {
    //     $product = Product::with('images')->findOrFail($id);
    //     return response()->json($product);
    // }
    public function getSizeChart()
    {
        // URL hoặc đường dẫn ảnh bảng kích thước
        $sizeChartUrl = asset('/template/user/images/size.jpg');

        return response()->json(['url' => $sizeChartUrl]);
    }

    public function product(Request $request)
    {
        $productss = $this->menuService->getmainProducts($request)->paginate(16)->withQueryString();
        $products = $this->cartService->getProduct();
        $totalProducts = Product::count(); // Lấy tổng số sản phẩm
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

        return view('user.shop', [
            'title' => 'Shop LouVu',
            'menus' => $this->menuService->show(),
            'productss' => $productss,
            'products' => $products,
            'carts' => $cartItems,
            'countCart' => $countCart,
            'starRatings' => $starRatings,
            'totalProducts' => $totalProducts, // Truyền tổng số sản phẩm vào view
        ]);
    }
    public function proSlider()
    {
        $productss = Product::where('name', 'LIKE', '%thu đông%')
            ->orWhere('description', 'LIKE', '%thu đông%')
            ->paginate(12);
        $products = $this->cartService->getProduct();
        $totalProducts = Product::count(); // Lấy tổng số sản phẩm
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

        return view('user.proslider', [
            'title' => 'BST LouVu',
            'menus' => $this->menuService->show(),
            'productss' => $productss,
            'products' => $products,
            'carts' => $cartItems,
            'countCart' => $countCart,
            'starRatings' => $starRatings,
            'totalProducts' => $totalProducts, // Truyền tổng số sản phẩm vào view
        ]);
    }
    public function loadProduct(Request $request)
    {
        $page = $request->input('page', 0); // Lấy giá trị page từ request, mặc định là 0
        $result = $this->productService->get($page);

        if ($result->isNotEmpty()) { // Sử dụng isNotEmpty để kiểm tra
            $html = view('user.product', ['productss' => $result])->render();
            return response()->json(['html' => $html]);
        }

        return response()->json(['html' => '']);
    }

    public function contact()
    {
        $products = $this->cartService->getProduct();
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

        return view(
            'user.contact',
            [
                'title' => 'Contact',
                'menus' => $this->menuService->show(),
                'products' => $products,
                'carts' => $cartItems,
                'countCart' => $countCart
            ]
        );
    }
    public function about()
    {
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

        $products = $this->cartService->getProduct();
        return view(
            'user.about',
            [
                'title' => 'About',
                'menus' => $this->menuService->show(),
                'products' => $products,
                'carts' => $cartItems,
                'countCart' => $countCart
            ]
        );
    }
    public function send(MessageFormRequest $request)
    {
        if ($request) {
            $email = $request->string('email');
            $content = $request->string('content');
            Message::create([
                'email' => $email,
                'content' => $content
            ]);
        }
        Session::flash('success', 'Cảm ơn bạn đã gửi cho chúng tôi lời nhắn!');
        return redirect()->back();
    }
    public function review(ReviewFormRequest $request, $product_id)
    {
        // Tìm khách hàng dựa trên email và số điện thoại
        $customer = Customer::where('email', $request->input('email'))
            ->where('phone', $request->input('phone'))
            ->first();

        if (!$customer) {
            // Nếu không tìm thấy khách hàng, trả về thông báo lỗi cho AJAX
            return response()->json(['error' => 'Bạn chưa mua hàng tại LouVu? Hãy trải nghiệm dịch vụ và đánh giá sản phẩm của chúng tôi.'], 400);
        }

        // Tìm các đơn hàng đã giao của khách hàng
        $orders = Order::where('customer_id', $customer->id)->where('order_status', 'Đã giao')->get();
        if ($orders->count() <= 0) {
            return response()->json(['error' => 'Bạn chưa có đơn hàng nào được giao.'], 400);
        }

        // Kiểm tra sản phẩm có trong bất kỳ đơn hàng nào không
        $hasPurchased = false;
        foreach ($orders as $order) {
            $orderItems = Order_item::where('order_id', $order->id)
                ->where('product_id', $product_id)
                ->first();
            Log::info('Orders:', ['order' => $order]);
            if ($orderItems) {
                $hasPurchased = true;
                break;
            }
        }

        if (!$hasPurchased) {
            return response()->json(['error' => 'Bạn chưa chưa mua sản phẩm này, hãy trải nghiệm và đánh giá nhé!'], 400);
        }

        // Tạo mới đánh giá
        Review::create([
            'customer_id' => $customer->id,
            'product_id' => $product_id,
            'rating' => $request->input('rating'),
            'content' => $request->input('content'),
            'order_id' => $order->id,
        ]);

        // Trả về thông báo thành công
        return response()->json(['success' => 'Cảm ơn bạn đã đánh giá.'], 200);
    }
}
