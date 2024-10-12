<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product_var;
use Illuminate\Http\Request;
use App\Http\Services\Order\OrderService;
use App\Models\Color;
use App\Models\Customer;
use App\Models\Message;
use App\Models\Order;
use App\Models\Order_item;
use App\Models\Product;
use App\Models\Size;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class OrderController extends Controller
{
    //
    protected $orderService;
    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }


    public function getOrdersByMonth($month)
    {
        // Tính tổng doanh thu của tất cả các đơn hàng trong tháng
        $totalRevenue = Order::where('order_status', 'Đã giao')->whereMonth('created_at', $month)->sum('total'); // Giả sử cột `total` là cột lưu tổng tiền

        return response()->json([
            'totalRevenue' => $totalRevenue
        ]);
    }



    public function index()
    {
        $orders = $this->orderService->getAll();
        $messages = Message::select('email', 'content')->orderByDesc('id')->get();
        $msCount = Message::count();
        return view('admin.orders.list', [
            'title' => 'List order',
            'orders' => $orders,
            'messages' => $messages,
            'msCount' => $msCount,
        ]);
    }
    public function destroy(Request $request): JsonResponse
    {
        $result = $this->orderService->destroy($request);
        if ($result) {
            return response()->json([
                'error' => false,
                'message' => 'Deleted successful'
            ]);
        } else {
            return response()->json([
                'error' => true,
                'message' => 'Deleted failed'
            ]);
        }
    }
    public function show(Order $order)
    {
        $messages = Message::select('email', 'content')->orderByDesc('id')->get();
        $msCount = Message::count();
        $customer = Customer::select('name', 'phone', 'email', 'created_at',)
            ->where('id', $order->customer_id)
            ->first();

        // Eager load product relationship with order items
        $orderDetail = Order_item::with('product')
            ->where('order_id', $order->id)
            ->get();

        return view('admin.orders.orderDetails', [
            'title' => 'Order detail',
            'orderDetail' => $orderDetail,  // Pass order details with product information
            'customer' => $customer,  // Fix typo: 'cutomer' to 'customer'
            'order' => $order,
            'messages' => $messages,
            'msCount' => $msCount,
        ]);
    }
    public function edit(Order $order, Request $request)
    {
        $this->orderService->update($order, $request);
        return redirect()->back();
    }
    public function chartCol(Request $request)
    {
        // Lấy ngày bắt đầu từ request
        $startDate = $request->input('start_date');

        // Tính toán ngày kết thúc (thêm 6 ngày vào ngày bắt đầu)
        $endDate = date('Y-m-d', strtotime($startDate . ' + 6 days'));

        $salesData = DB::table('orders')
            ->where('order_status', '=', 'Đã giao')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->select(DB::raw('DATE(created_at) as date'), DB::raw('SUM(total) as total_sales'))
            ->groupBy(DB::raw('DATE(created_at)'))
            ->get();

        // Tạo mảng với doanh số cho từng ngày trong tuần
        $weeklySales = [];
        $currentDate = $startDate;

        // Lặp qua từng ngày từ startDate đến endDate
        for ($i = 0; $i < 7; $i++) {
            $formattedDate = date('Y-m-d', strtotime($currentDate . " + $i days"));
            $totalSales = $salesData->where('date', $formattedDate)->first();

            // Nếu không có doanh thu cho ngày này, set là 0
            $weeklySales[] = $totalSales ? $totalSales->total_sales : 0;
        }

        // Tạo nhãn cho biểu đồ
        $labels = [];
        for ($i = 0; $i < 7; $i++) {
            $labels[] = date('d/m', strtotime($currentDate . " + $i days")); // Hiển thị ngày và tháng
        }

        // Trả về dữ liệu dạng JSON cho JavaScript
        return response()->json(['labels' => $labels, 'sales' => $weeklySales]);
    }



    public function chartRod()
    {
        // Số lượng đơn hàng theo từng trạng thái
        $pending = DB::table('orders')->where('order_status', '=', 'Chờ xác nhận')->count();
        $inProgress = DB::table('orders')->where('order_status', '=', 'Đang giao')->count();
        $delivered = DB::table('orders')->where('order_status', '=', 'Đã giao')->count();
        $cancel = DB::table('orders')->where('order_status', '=', 'Đã huỷ')->count();
        // Trả về dữ liệu dạng JSON cho JavaScript
        return response()->json([
            'labels' => ['Chờ xác nhận', 'Đang giao', 'Đã giao', 'Đã huỷ'],
            'data' => [$pending, $inProgress, $delivered, $cancel],
        ]);
    }
    public function print(Order $order)
    {
        $customer = Customer::select('name', 'phone', 'email', 'created_at')
            ->where('id', $order->customer_id)
            ->first();
        $orderDetail = Order_item::with('product')
            ->where('order_id', $order->id)
            ->get();
        $data = [
            'orderDetail' => $orderDetail,
            'customer' => $customer,
            'order' => $order
        ];

        $pdf = PDF::loadView('admin.orders.orderPDF', $data)->setOptions([
            'isHtml5ParserEnabled' => true,
            'isRemoteEnabled' => true,
            'defaultFont' =>
            'DejaVu Sans',

        ]);
        return $pdf->download('order_' . $order->id . '.pdf');
    }
    public function getStatis()
    {
        $messages = Message::select('email', 'content')->orderByDesc('id')->get();
        $msCount = Message::count();
        $totalSoldProducts = DB::table('order_items as oi')
            ->join('orders as o', 'oi.order_id', '=', 'o.id')
            ->where('o.order_status', '=', 'Đã giao')
            ->sum('oi.qty'); // Tổng số sản phẩm đã bán
        $remainingProducts = Product::sum('qty_Stock'); // Số sản phẩm còn lại trong kho
        $totalCustomers = Customer::count(); // Số khách hàng đã mua
        $totalRevenue = Order::where('order_status', 'Đã giao')->sum('total'); // Tổng doanh thu
        // Top 5 sản phẩm bán chậm nhất
        $topSellingProducts = Product::select(
            'products.id',
            'products.name',
            'products.price',
            'products.price_sale',
            'products.thumb',
            'products.qty_stock',
            'products.image1',
            'products.image2',
            'products.image3',
            DB::raw('IFNULL(SUM(order_items.qty), 0) as total_qty') // Nếu không có giá trị, đặt mặc định là 0
        )
            ->leftJoin('order_items', 'products.id', '=', 'order_items.product_id') // Sử dụng LEFT JOIN để lấy cả sản phẩm chưa được bán
            ->where('products.active', 1)
            ->groupBy('products.id', 'products.name', 'products.price', 'products.price_sale', 'products.thumb', 'products.qty_stock', 'products.image1', 'products.image2', 'products.image3')
            ->orderBy('total_qty', 'asc') // Để sắp xếp theo số lượng bán ít nhất
            ->take(5)
            ->get();
        // Top 5 sản phẩm bán chạy nhất
        $leastSellingProducts =
            Product::with('orderItems')
            ->select('products.id', 'products.name', 'products.price', 'products.thumb', DB::raw('SUM(order_items.qty) as sold_qty'))
            ->join('order_items', 'products.id', '=', 'order_items.product_id')
            ->groupBy('products.id', 'products.name', 'products.price', 'products.thumb')
            ->orderBy('sold_qty', 'desc') // Để sắp xếp theo số lượng bán ít nhất
            ->take(5)
            ->get();
        return view('admin.orders.statis', [
            'title' => 'Statistical',
            'totalSoldProducts' => $totalSoldProducts,
            'remainingProducts' => $remainingProducts,
            'totalCustomers' => $totalCustomers,
            'totalRevenue' => $totalRevenue,
            'topSellingProducts' => $topSellingProducts,
            'leastSellingProducts' => $leastSellingProducts,
            'messages' => $messages,
            'msCount' => $msCount,
        ]);
    }
    public function getNow()
    {
        $messages = Message::select('email', 'content')->orderByDesc('id')->get();
        $msCount = Message::count();
        $orders = Order::whereDate('created_at', Carbon::today())->paginate(10);
        return view('admin.orders.list', [
            'title' => 'Order today',
            'orders' => $orders,
            'messages' => $messages,
            'msCount' => $msCount,
        ]);
    }
    public function getLast()
    {
        $messages = Message::select('email', 'content')->orderByDesc('id')->get();
        $msCount = Message::count();
        $orders = Order::whereDate('created_at', Carbon::yesterday())->paginate(10);
        return view('admin.orders.list', [
            'title' => 'Order yesterday',
            'orders' => $orders,
            'messages' => $messages,
            'msCount' => $msCount,
        ]);
    }
    public function cancel($id)
    {
        // Lấy đơn hàng bằng ID
        $order = Order::findOrFail($id);

        // Kiểm tra xem đơn hàng có thuộc về khách hàng đang đăng nhập không
        if ($order->customer_id !== session('customerRole.id')) {
            return redirect()->back()->withErrors('Bạn không có quyền hủy đơn hàng này.');
        }

        // Kiểm tra nếu trạng thái đơn hàng đã hoàn thành hoặc đã giao, không cho phép hủy
        if ($order->order_status === 'Đã giao' || $order->order_status === 'Đang giao') {
            return redirect()->back()->withErrors('Bạn không thể hủy đơn hàng.');
        }

        // Lấy tất cả các sản phẩm trong đơn hàng
        $orderItems = $order->order_items; // Giả định orderItems là mối quan hệ giữa Order và OrderItem
        foreach ($orderItems as $item) {
            // Tìm size_id và color_id dựa trên tên size và color từ bảng sizes và colors
            $size = Size::where('name', $item->size)->first();
            $color = Color::where('name', $item->color)->first();

            // Kiểm tra nếu tìm thấy cả size và color
            if ($size && $color) {
                // Lấy product_var dựa trên product_id, size_id và color_id
                $productVar = Product_var::where('product_id', $item->product_id)
                    ->where('size_id', $size->id) // Sử dụng size_id
                    ->where('color_id', $color->id) // Sử dụng color_id
                    ->first();

                // Nếu tồn tại product_var, cập nhật lại số lượng
                if ($productVar) {
                    $productVar->qty += $item->qty;
                    $productVar->save();
                }

                // Cập nhật lại qty_stock trong bảng products
                $product = Product::find($item->product_id);
                if ($product) {
                    $product->qty_stock += $item->qty;
                    $product->save();
                }
            }
        }

        // Cập nhật trạng thái đơn hàng thành "Đã hủy"
        $order->order_status = 'Đã hủy';
        $order->save();

        // Chuyển hướng về trang trước với thông báo thành công
        return redirect()->back()->with('success', 'Đơn hàng đã được hủy thành công.');
    }
}
