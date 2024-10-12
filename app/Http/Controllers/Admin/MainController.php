<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Message;
use App\Models\Order;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class MainController extends Controller
{
    //
    public function index()
    {
        // Doanh số theo ngày hiện tại (chỉ lấy doanh thu của ngày hôm nay)
        $salesDay = DB::table('orders')->where('order_status', '=', 'Đã giao')
            ->whereDate('created_at', Carbon::today()) // Sử dụng Carbon để chính xác hơn
            ->sum('total');

        // Doanh số theo tuần hiện tại (lấy từ đầu tuần đến cuối tuần)
        $salesWeek =
            DB::table('orders')->where('order_status', '=', 'Đã giao')
            ->whereDate('created_at', Carbon::yesterday()) // Sử dụng Carbon để chính xác hơn
            ->sum('total');

        // Doanh số theo tháng hiện tại (lấy theo tháng và năm hiện tại)
        $salesMonth = DB::table('orders')->where('order_status', '=', 'Đã giao')
            ->sum('total');
        $messages = Message::select('email', 'content')->orderByDesc('id')->get();
        $msCount = Message::count();
        return view('admin.home', [
            'title' => 'Dashboard',
            'totalProduct' => DB::table('order_items as oi')
                ->join('orders as o', 'oi.order_id', '=', 'o.id')
                ->where('o.order_status', '=', 'Đã giao')
                ->sum('oi.qty'),
            'countTotal' => Order::count(),
            'countOd' => Order::whereDate('created_at', Carbon::today())->count(),
            'countCt' => Customer::count(),
            'messages' => $messages,
            'msCount' => $msCount,
            'countRv' => Review::count(),
            'salesDay' => $salesDay,
            'salesMonth' => $salesMonth,
            'salesWeek' => $salesWeek
        ]);
    }
}
