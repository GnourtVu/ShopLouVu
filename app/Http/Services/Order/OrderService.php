<?php

namespace App\Http\Services\Order;

use App\Models\Order;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class OrderService
{
    public function getAll()
    {
        return Order::select('id', 'customer_id', 'payment_method', 'order_status', 'total', 'created_at')->orderByDesc('created_at')->with('order_items')->paginate(15);
    }
    public function destroy($request)
    {
        $id = $request->input('id');
        if (!$id) {
            return false;
        }
        $customer = Order::where('id', $id)->first();
        if ($customer) {
            return Order::where('id', $id)->delete();
        }
        return false;
    }
    public function update($order, $request)
    {
        if ($order) {
            $order->payment_method = $request->input('payment_method');
            $order->order_status = $request->input('order_status');
            $order->save();
        }
        Session::flash('success', 'Update successful');
    }
}
