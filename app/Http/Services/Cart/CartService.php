<?php

namespace App\Http\Services\Cart;

use App\Jobs\SendMail;
use App\Mail\OrderShipped;
use App\Models\Cart;
use App\Models\Cart_Item;
use App\Models\Color;
use App\Models\Customer;
use App\Models\Order;
use App\Models\Order_item;
use App\Models\Product;
use App\Models\Product_var;
use App\Models\Size;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;

class CartService
{
    public function create($request): bool
    {
        // Lấy số lượng, ID sản phẩm, size và color từ request
        $qty = (int) $request->input('num_product');
        $product_id = (int) $request->input('product_id');
        $size = (string) $request->input('size');
        $color = (string) $request->input('color');

        // Kiểm tra xem người dùng đã chọn size và color hay chưa
        if ($color === 'Chọn màu phù hợp') {
            Session::flash('error', 'Bạn chưa chọn màu.');
            return false;
        }
        if ($size === 'Chọn size phù hợp') {
            Session::flash('error', 'Bạn chưa chọn size.');
            return false;
        }

        // Kiểm tra số lượng và sản phẩm có hợp lệ không
        if ($qty <= 0 || $product_id <= 0) {
            Session::flash('error', 'Bạn phải chọn ít nhất 1 sản phẩm để thêm vào giỏ hàng.');
            return false;
        }

        // Lấy giỏ hàng từ session
        $carts = Session::get('carts', []);
        $customer = Session::get('customerRole');

        // Nếu khách hàng đã đăng nhập, xử lý lưu vào cơ sở dữ liệu
        if ($customer) {
            // Tìm giỏ hàng của khách hàng
            $cart = Cart::where('customer_id', $customer->id)->first();

            // Nếu khách hàng chưa có giỏ hàng, tạo mới giỏ hàng
            if (!$cart) {
                $cart = Cart::create([
                    'customer_id' => $customer->id,
                ]);
            }

            // Tìm item trong giỏ hàng với cùng product_id, size, color
            $cartItem = Cart_Item::where('cart_id', $cart->id)
                ->where('product_id', $product_id)
                ->where('size', $size)
                ->where('color', $color)
                ->first();

            if ($cartItem) {
                // Nếu đã có item với cùng sản phẩm, cập nhật số lượng
                $cartItem->qty += $qty;
                $cartItem->save();
            } else {
                // Nếu chưa có item, thêm sản phẩm mới vào giỏ hàng
                Cart_Item::create([
                    'cart_id' => $cart->id,
                    'product_id' => $product_id,
                    'qty' => $qty,
                    'size' => $size,
                    'color' => $color,
                ]);
            }
        } else {
            // Nếu chưa đăng nhập, lưu giỏ hàng vào session

            // Kiểm tra xem sản phẩm với size và color đã tồn tại chưa
            if (isset($carts[$product_id][$size][$color])) {
                // Nếu tồn tại, cộng dồn số lượng
                $carts[$product_id][$size][$color] += $qty;
            } else {
                // Nếu chưa tồn tại, thêm sản phẩm mới với size, color và số lượng
                $carts[$product_id][$size][$color] = $qty;
            }

            // Lưu giỏ hàng vào session
            Session::put('carts', $carts);
        }

        return true;
    }


    public function getProduct()
    {
        $customer = Session::get('customerRole');

        // Kiểm tra khách hàng đã đăng nhập
        if ($customer) {
            // Lấy các ID sản phẩm từ giỏ hàng của khách hàng
            $product_ids = Cart_Item::whereHas('cart', function ($query) use ($customer) {
                $query->where('customer_id', $customer->id);
            })->pluck('product_id'); // Lấy product_id từ Cart_Item

            // Nếu không có sản phẩm nào, trả về mảng rỗng
            if ($product_ids->isEmpty()) {
                return [];
            }

            // Lấy thông tin sản phẩm từ bảng Product
            return Product::select('id', 'name', 'price', 'price_sale', 'thumb')
                ->where('active', 1)
                ->whereIn('id', $product_ids)
                ->get();
        } else {
            // Nếu khách hàng không đăng nhập, lấy giỏ hàng từ session
            $carts = Session::get('carts', []);

            // Nếu giỏ hàng trống, trả về mảng rỗng
            if (empty($carts)) {
                return [];
            }

            // Lấy các ID sản phẩm từ giỏ hàng trong session
            $product_ids = array_keys($carts);

            // Lấy thông tin sản phẩm từ bảng Product
            return Product::select('id', 'name', 'price', 'price_sale', 'thumb')
                ->where('active', 1)
                ->whereIn('id', $product_ids)
                ->get();
        }
    }

    public function update(Request $request)
    {
        $customer = Session::get('customerRole'); // Lấy thông tin khách hàng

        // Nếu khách hàng đã đăng nhập
        if ($customer) {
            // Lấy danh sách sản phẩm từ yêu cầu
            $products = $request->input('num_product');

            // Cập nhật giỏ hàng trong cơ sở dữ liệu
            foreach ($products as $productId => $productDetails) {
                foreach ($productDetails as $size => $colors) {
                    foreach ($colors as $color => $qty) {
                        // Tìm giỏ hàng của khách hàng
                        $cart = Cart::where('customer_id', $customer->id)->first();
                        if ($cart) {
                            // Cập nhật số lượng sản phẩm trong giỏ hàng
                            Cart_Item::where('cart_id', $cart->id)
                                ->where('product_id', $productId)
                                ->where('size', $size)
                                ->where('color', $color)
                                ->update(['qty' => $qty]);
                        }
                    }
                }
            }

            return redirect('/cart')->with('success', 'Giỏ hàng đã được cập nhật!');
        } else {
            // Nếu không có khách hàng, lưu giỏ hàng vào session
            Session::put('carts', $request->input('num_product'));
            return redirect('/cart')->with('success', 'Giỏ hàng đã được cập nhật trong session!');
        }
    }

    public function delete($id, $size, $color): bool
    {
        $customer = Session::get('customerRole'); // Lấy thông tin khách hàng

        // Nếu khách hàng đã đăng nhập
        if ($customer) {
            // Tìm giỏ hàng của khách hàng
            $cart = Cart::where('customer_id', $customer->id)->first();

            if ($cart) {
                // Tìm sản phẩm trong giỏ hàng
                $cartItem = Cart_Item::where('cart_id', $cart->id)
                    ->where('product_id', $id)
                    ->where('size', $size)
                    ->where('color', $color)
                    ->first();

                if ($cartItem) {
                    // Xóa sản phẩm khỏi giỏ hàng
                    $cartItem->delete();

                    // Kiểm tra xem có còn sản phẩm nào khác trong giỏ hàng không
                    if ($cart->items()->count() === 0) {
                        // Nếu không còn sản phẩm nào trong giỏ hàng, có thể xóa giỏ hàng
                        $cart->delete();
                    }

                    return true; // Trả về true nếu xóa thành công
                }
            }
        } else {
            // Nếu không có khách hàng, xóa sản phẩm khỏi session
            $carts = Session::get('carts');

            // Kiểm tra xem sản phẩm có tồn tại trong giỏ hàng không
            if (isset($carts[$id][$size][$color])) {
                // Xóa sản phẩm theo size và color
                unset($carts[$id][$size][$color]);

                // Nếu không còn size nào nữa cho sản phẩm này, xóa sản phẩm khỏi giỏ hàng
                if (empty($carts[$id][$size])) {
                    unset($carts[$id][$size]);
                }

                // Nếu không còn size nào cho sản phẩm này, xóa sản phẩm khỏi giỏ hàng
                if (empty($carts[$id])) {
                    unset($carts[$id]);
                }

                // Cập nhật lại session
                Session::put('carts', $carts);
                return true; // Trả về true nếu xóa thành công
            }
        }

        return false; // Trả về false nếu không tìm thấy sản phẩm
    }


    public function buy($request)
    {
        try {
            $customerRole = Session::get('customerRole');
            $paymentMethod = $this->getPaymentMethod($request->input('payment'));
            $status = '';
            if ($paymentMethod === 'Ví điện tử VNPAY') {
                $status = "Đã giao";
            } else {
                $status = 'Chờ xác nhận';
            }
            DB::beginTransaction();
            if ($customerRole) {
                $customer = Customer::where('id', $customerRole->id)->first();
                $cart = Cart::where('customer_id', $customerRole->id)->first();
                $cartItems = Cart_Item::where('cart_id', $cart->id)->get();
                $total = 0;
                $priceEnd = 0;
                $discount = Session::get('discount');
                if (Session::get('pointOd')) {
                    $point = Session::get('pointOd');
                } else {
                    $point = 0;
                }
                foreach ($cartItems as $item) {
                    $product = $item->product;
                    $price_End = $product->price * $item->qty;
                    $priceEnd += $price_End;
                }

                $total = $priceEnd + 30000 - $discount - $point;

                $order = Order::create([
                    'total' => $total,
                    'customer_id' => $customerRole->id,
                    'payment_method' => $paymentMethod,
                    'order_status' => $status,
                    'content' => $request->input('content'),
                    'address' => $request->input('address'),
                    'discount' => $discount + $point,
                    'province' => $request->input('province'),
                    'district' => $request->input('district'),
                    'ward' => $request->input('ward')
                ]);

                // Tính điểm dựa trên tổng giá trị đơn hàng hiện tại
                if (Session::has('pointOd')) {
                    // Nếu có sử dụng điểm thì trừ điểm đã sử dụng, nhưng vẫn phải cộng điểm mới từ đơn hàng
                    $usedPoints = Session::get('pointOd');
                    $customer->point -= $usedPoints; // Trừ điểm đã sử dụng trong đơn hàng hiện tại
                    $customer->point += ($order->total / 10000); // Cộng điểm mới từ đơn hàng vừa đặt
                } else {
                    $customer->point += $order->total / 10000; // Cộng điểm mới nếu không có điểm sử dụng
                }


                $customer->save();

                foreach ($cartItems as $item) {
                    $orderItem = Order_item::create([
                        'order_id' => $order->id,
                        'product_id' => $item->product_id,
                        'size' => $item->size,
                        'color' => $item->color,
                        'qty' => $item->qty,
                        'price' => $item->product->price
                    ]);

                    // Cập nhật số lượng trong bảng product_vars
                    $color = Color::where('name', $item->color)->first();
                    $size = Size::where('name', $item->size)->first();
                    $productVar = Product_var::where('product_id', $item->product_id)
                        ->where('size_id', $size->id)
                        ->where('color_id', $color->id)
                        ->first();

                    if ($productVar) {
                        $productVar->qty -= $item->qty; // Giảm số lượng tồn kho trong product_vars
                        if ($productVar->qty < 0) {
                            throw new \Exception('Sản phẩm không đủ trong kho.');
                        }
                        $productVar->save(); // Lưu thay đổi
                    }
                }

                // Xóa từng item trong giỏ hàng
                foreach ($cartItems as $item) {
                    $item->delete();
                }

                $cart->delete(); // Xóa giỏ hàng

                // Cập nhật số lượng trong bảng products
                foreach ($cartItems as $item) {
                    $product = Product::find($item->product_id);
                    if ($product) {
                        $product->qty_stock -= $item->qty; // Giảm số lượng tồn kho
                        if ($product->qty_stock < 0) {
                            throw new \Exception('Sản phẩm không đủ trong kho (products).');
                        }
                        $product->save(); // Lưu thay đổi
                    }
                }

                Session::forget('discount');
                Session::forget('pointOd');
            } else {
                $carts = Session::get('carts');
                if (is_null($carts) || empty($carts)) {
                    return false; // Giỏ hàng rỗng, không thể tiếp tục
                }

                // Kiểm tra xem khách hàng có tồn tại hay không
                $customer = Customer::create([
                    'name' => $request->input('name'),
                    'email' => $request->input('email'),
                    'phone' => $request->input('phone'),
                    'password' => null,
                    'point' => 0,
                    'role' => 0,
                ]);
                if (!$customer) {
                    throw new \Exception('Không thể tạo khách hàng'); // Hoặc trả về một lỗi hợp lý
                }
                $totals = $this->calculateTotal($carts);
                // Xử lý giá trị của phương thức thanh toán
                $paymentMethod = $this->getPaymentMethod($request->input('payment'));

                // Tạo đơn hàng
                $order = Order::create([
                    'total' => $totals['total'],
                    'customer_id' => $customer->id,
                    'payment_method' => $paymentMethod,
                    'order_status' => $status,
                    'content' => $request->input('content'),
                    'address' => $request->input('address'),
                    'discount' => $totals['discount'],
                    'province' => $request->input('province'),
                    'district' => $request->input('district'),
                    'ward' => $request->input('ward')
                ]);

                Session::put('order', $order);
                $this->order_Item($order->id, $carts);

                // Tạo một mảng để lưu trữ số lượng cho mỗi sản phẩm
                $totalQty = [];

                // Tính toán tổng số lượng cho mỗi sản phẩm
                foreach ($carts as $product_id => $sizes) {
                    foreach ($sizes as $size => $colors) {
                        foreach ($colors as $color => $quantity) {
                            // Tính tổng số lượng cho sản phẩm này
                            if (!isset($totalQty[$product_id])) {
                                $totalQty[$product_id] = 0; // Khởi tạo nếu chưa tồn tại
                            }
                            $totalQty[$product_id] += $quantity; // Cộng dồn số lượng
                        }
                    }
                }

                // Cập nhật số lượng sản phẩm trong bảng sản phẩm
                foreach ($totalQty as $product_id => $qty) {
                    $product = Product::find($product_id);
                    if ($product) {
                        $product->qty_stock -= $qty; // Giảm số lượng tồn kho
                        if ($product->qty_stock < 0) {
                            throw new \Exception('Sản phẩm không đủ trong kho'); // Kiểm tra số lượng tồn kho
                        }
                        $product->save(); // Lưu thay đổi
                    }
                }
                // Lưu thay đổi một lần sau khi đã giảm tất cả


                $totalStock = $this->calculateProductStock($product_id);
                $product = Product::find($product_id);
                $product->qty_stock = $totalStock; // Cập nhật số lượng tồn kho
                $product->save(); // Lưu thay đổi
                $count = Session::get('count', 0);
                Session::put('count', $count + 1);
                Session::forget('discount');
                Session::forget('carts');
            }


            DB::commit();
            SendMail::dispatch($request->input('email'))->delay(now()->addSeconds(2));
            Mail::to($request->input('email'))->send(new OrderShipped($order));
            Session::flash('success', 'Đặt hàng thành công.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Order error: ' . $e->getMessage());
            Log::error('Request data: ', $request->all());
            Log::error('Session data: ', Session::all()); // Ghi lại toàn bộ session
            Log::info('Customer Role: ', ['customerRole' => $customerRole]);
            Log::info('Customer ID: ', ['id' => $customerRole->id ?? null]);
            Session::flash('error', 'Đặt hàng thất bại, vui lòng thử lại sau.');
            return false;
        }

        return true;
    }

    private function calculateProductStock($product_id)
    {
        // Tính tổng số lượng tồn kho từ bảng product_var dựa trên product_id
        return Product_var::where('product_id', $product_id)
            ->sum('qty'); // Tổng số lượng tồn kho của sản phẩm theo kích thước và màu sắc
    }


    private function getPaymentMethod($payment)
    {
        switch ($payment) {
            case 'cash':
                return 'Tiền mặt';
            case 'vnpay':
                return 'Ví điện tử VNPAY';
            default:
                return 'Phương thức không xác định';
        }
    }


    protected function calculateTotal($carts)
    {
        $subtotal = 0;
        $discount = Session::get('discount', 0);

        // Tính tổng giá sản phẩm
        foreach ($carts as $product_id => $sizes) {
            foreach ($sizes as $size => $colors) {
                foreach ($colors as $color => $qty) {
                    $product = Product::where('id', $product_id)->first();
                    $product = Product::find($product_id);
                    if ($product) {
                        $subtotal += $product->price * $qty;
                    }
                }
            }
        }

        // Kiểm tra và áp dụng chiết khấu
        $total = $subtotal - $discount + 30000;

        return [
            'subtotal' => $subtotal,
            'discount' => $discount,
            'total' => $total
        ];
    }



    protected function order_Item($order_id, $carts)
    {
        $data = [];
        foreach ($carts as $product_id => $sizes) {
            foreach ($sizes as $size => $colors) {
                foreach ($colors as $color => $quantity) {
                    // Tìm kiếm thông tin kích thước
                    $sizeRecord = Size::where('name', $size)->first();
                    if (!$sizeRecord) {
                        Log::error("Size not found: {$size}");
                        continue; // Bỏ qua nếu không tìm thấy kích thước
                    }

                    // Tìm kiếm thông tin màu sắc
                    $colorRecord = Color::where('name', $color)->first();
                    if (!$colorRecord) {
                        Log::error("Color not found: {$color}");
                        continue; // Bỏ qua nếu không tìm thấy màu sắc
                    }
                    $product = Product::where('id', $product_id)->first();
                    // Tìm kiếm thông tin sản phẩm
                    $productVar = Product_var::where('product_id', $product_id)
                        ->where('size_id', $sizeRecord->id) // Dùng size_id từ bảng size
                        ->where('color_id', $colorRecord->id) // Dùng color_id từ bảng color
                        ->first();

                    if ($productVar) {
                        // Kiểm tra xem đã có sản phẩm với cùng order_id, product_id, size, color trong $data chưa
                        $existingItem = collect($data)->first(function ($item) use ($product_id, $size, $color) {
                            return $item['product_id'] === $product_id && $item['size'] === $size && $item['color'] === $color;
                        });

                        if ($existingItem) {
                            // Nếu đã tồn tại, chỉ cập nhật số lượng
                            $existingItem['qty'] += (int)$quantity;
                        } else {
                            // Thêm sản phẩm mới vào data
                            $data[] = [
                                'order_id' => $order_id,
                                'product_id' => $product_id,
                                'qty' => (int)$quantity,
                                'price' => (float)$product->price, // Lấy giá từ bảng product_var
                                'size' => $size,
                                'color' => $color // Lưu màu
                            ];
                        }

                        // Cập nhật số lượng trong product_var
                        $productVar->qty -= $quantity; // Giảm số lượng
                        $productVar->save(); // Lưu thay đổi
                    } else {
                        Log::error("Product variant not found for product ID {$product_id}, size ID {$sizeRecord->id}, color ID {$colorRecord->id}.");
                    }
                }
            }
        }

        if (!empty($data)) {
            $inserted = Order_item::insert($data);
            if (!$inserted) {
                Log::error("Failed to insert order items for order ID {$order_id}.");
            }
            return $inserted;
        } else {
            Log::warning("No data to insert for order ID {$order_id}.");
            return false;
        }
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
