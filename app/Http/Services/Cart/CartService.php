<?php

namespace App\Http\Services\Cart;

use App\Jobs\SendMail;
use App\Models\Cart;
use App\Models\Customer;
use App\Models\Product;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class CartService
{
    public function create($request): bool
    {
        $qty = (int)$request->input('num_product');
        $product_id = (int)$request->input('product_id');

        if ($qty <= 0 || $product_id <= 0) {
            Session::flash('error', 'Quantity or product is not correct');
            return false;
        }

        $carts = Session::get('carts', []);

        if (Arr::exists($carts, $product_id)) {
            // Cập nhật số lượng sản phẩm hiện có
            $carts[$product_id] += $qty;
        } else {
            // Thêm sản phẩm mới vào giỏ hàng
            $carts[$product_id] = $qty;
        }

        // Cập nhật session với giỏ hàng mới
        Session::put('carts', $carts);
        return true;
    }

    public function getProduct()
    {
        $carts = Session::get('carts', []);

        if (empty($carts)) {
            return [];
        }

        $product_id = array_keys($carts);

        return Product::select('id', 'name', 'price', 'price_sale', 'thumb')
            ->where('active', 1)
            ->whereIn('id', $product_id)
            ->get();
    }
    public function update($request)
    {
        Session::put('carts', $request->input('num_product'));
        return true;
    }
    public function delete($id)
    {
        $carts = Session::get('carts');
        unset($carts[$id]);
        Session::put('carts', $carts);
        return true;
    }
    public function buy($request)
    {
        try {
            DB::beginTransaction();
            $carts = Session::get('carts');
            if (is_null($carts))
                return false;
            $customer = Customer::create([
                'name' => $request->string('name'),
                'email' => $request->string('email'),
                'address' => $request->string('address'),
                'phone' => $request->string('phone'),
                'content' => $request->string('content')
            ]);
            $this->inforProduct($customer->id, $carts);
            DB::commit();

            #Queue
            SendMail::dispatch($request->input('email'))->delay(now()->addSecond(2));
            Session::forget('carts');
        } catch (\Exception $e) {
            DB::rollBack();
            Session::flash('error', 'Order failed , Please try again later');
            return false;
        }
    }
    protected function inforProduct($customer_id, $carts)
    {
        $product_id = array_keys($carts);
        $products = Product::select('id', 'name', 'price', 'price_sale', 'thumb')
            ->where('active', 1)
            ->whereIn('id', $product_id)
            ->get();
        $data = [];
        foreach ($products as $key => $product) {
            $data[] = [
                'customer_id' => $customer_id,
                'product_id' => $product->id,
                'qty' => $carts[$product->id],
                'price' => $product->price,
            ];
        }
        return Cart::insert($data);
    }
    public function getCartList()
    {
        return Customer::select('id', 'name', 'address', 'phone', 'content', 'email', 'created_at')->orderByDesc('id')->paginate(10);
    }
    public function destroy($request)
    {
        $id = $request->input('id');
        if (!$id) {
            return false;
        }
        $customer = Customer::where('id', $id)->first();
        if ($customer) {
            return Customer::where('id', $id)->delete();
        }
        return false;
    }
}
