<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Services\Cart\CartService;
use App\Models\Cart;
use App\Models\Customer;
use App\Models\Product;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\JsonResponse;

class CartController extends Controller
{
    //
    protected $cartService;
    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }
    public function index()
    {
        return view('admin.carts.list', [
            'title' => 'List orders',
            'customers' => $this->cartService->getCartList()
        ]);
    }
    public function destroy(Request $request): JsonResponse
    {
        $result = $this->cartService->destroy($request);
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
    public function show(Customer $customer)
    {
        $order = Cart::select('discount', 'total')->where('customer_id', $customer->id)->first();
        return view('admin.carts.viewOrder', [
            'title' => 'Order detail ',
            'customer' => $customer,
            'carts' => $customer->carts()->with('product')->get(),
            'order' => $order
        ]);
    }
}
