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
            Session::flash('error', 'Bạn phải chọn ít nhất 1 sản phẩm để thêm vào giỏ hàng.');
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
            if (is_null($carts)) {
                return false;
            }
            $customer = Customer::where('phone', $request->input('phone'))->first();
            if (!$customer) {
                // Tạo khách hàng mới nếu không tồn tại
                $customer = Customer::create([
                    'name' => $request->input('name'),
                    'email' => $request->input('email'),
                    'address' => $request->input('address'),
                    'phone' => $request->input('phone'),
                    'content' => $request->input('content')
                ]);
            } else {
                // Cập nhật thông tin khách hàng nếu đã tồn tại
                $customer->update([
                    'name' => $request->input('name'),
                    'email' => $request->input('email'),
                    'address' => $request->input('address'),
                    'content' => $request->input('content')
                ]);
            }

            // Tính tổng tiền và lưu vào cơ sở dữ liệu
            $totals = $this->calculateTotal($carts);

            // Lưu thông tin sản phẩm vào bảng cart
            $this->inforProduct($customer->id, $carts, $totals['total'], $totals['discount']);
            // Cập nhật số lượng sản phẩm trong bảng sản phẩm
            foreach ($carts as $product_id => $qty) {
                $product = Product::find($product_id);
                if ($product) {
                    $product->qty_stock -= $qty; // Giả sử bạn có trường quantity trong bảng sản phẩm
                    if ($product->qty_stock < 0) {
                        throw new \Exception('Sản phẩm không đủ trong kho'); // Kiểm tra số lượng tồn kho
                    }
                    $product->save(); // Lưu thay đổi
                }
            }
            DB::commit();

            // Gửi email thông qua queue
            SendMail::dispatch($request->input('email'))->delay(now()->addSecond(2));
            // Xóa session giỏ hàng sau khi đặt hàng
            Session::flash('success', 'Đặt hàng thành công');
            Session::forget('discount');
            Session::forget('carts');
        } catch (\Exception $e) {
            DB::rollBack();
            Session::flash('error', 'Order failed, Please try again later');
            return false;
        }
        return true;
    }

    protected function calculateTotal($carts)
    {
        $subtotal = 0;
        $discount = Session::get('discount', 0); // Lấy giảm giá từ session, nếu có

        // Tính tổng giá sản phẩm
        foreach ($carts as $product_id => $qty) {
            $product = Product::find($product_id);
            if ($product) {
                $subtotal += $product->price * $qty;
            }
        }

        // Tính tổng tiền sau giảm giá
        $total = $subtotal - $discount + 30000;

        return [
            'subtotal' => $subtotal,
            'discount' => $discount,
            'total' => $total
        ];
    }

    protected function inforProduct($customer_id, $carts, $total, $discount)
    {
        $product_id = array_keys($carts);
        $products = Product::select('id', 'name', 'price', 'price_sale', 'thumb')
            ->where('active', 1)
            ->whereIn('id', $product_id)
            ->get();

        $data = [];
        foreach ($products as $product) {
            $data[] = [
                'customer_id' => $customer_id,
                'product_id' => $product->id,
                'qty' => $carts[$product->id],
                'price' => $product->price,
                'total' => $total, // Lưu tổng tiền cho từng sản phẩm
                'discount' => $discount // Lưu giảm giá nếu có
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
