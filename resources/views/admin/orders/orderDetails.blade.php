@extends('admin.main')
@section('content')
    <div class="invoice-box"
        style="max-width: 800px; margin: auto; padding: 30px; border: 1px solid #eee; box-shadow: 0 0 10px rgba(0, 0, 0, 0.15); font-size: 16px; line-height: 24px; font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; color: #555;">
        <div style="display: flex; justify-content: space-between;">
            <!-- Left Side: Order Information -->
            <div style="flex: 1; margin-right: 20px; padding: 20px; border: 1px solid #eee; border-radius: 8px;">
                <h2>Cập nhật đơn hàng</h2>
                <form method="post" action="/admin/edit/{{ $order->id }}" enctype="multipart/form-data">
                    <div style="margin-bottom: 10px;">
                        <p><strong>Mã đơn hàng:</strong> {{ $order->id }}</p>
                    </div>
                    <div style="margin-bottom: 10px;">
                        <p><strong>Phương thức thanh toán:</strong></p>
                        <select class="form-control" name="payment_method">
                            <option value="Tiền mặt" {{ $order->payment_method === 'Tiền mặt' ? 'selected' : '' }}>Tiền mặt
                            </option>
                            <option value="Ví điện tử VNPAY"
                                {{ $order->payment_method === 'Ví điện tử VNPAY' ? 'selected' : '' }}>Ví điện tử VNPAY
                            </option>
                        </select>
                    </div>
                    <div style="margin-bottom: 10px;">
                        <p><strong>Trạng thái đơn hàng:</strong></p>
                        <select name="order_status"
                            style="width: 100%; padding: 8px; border-radius: 4px; border: 1px solid #ddd;">
                            <option value="Chờ xác nhận" {{ $order->order_status == 'Chờ xác nhận' ? 'selected' : '' }}>Chờ
                                xác nhận
                            </option>
                            <option value="Đang giao" {{ $order->order_status == 'Đang giao' ? 'selected' : '' }}>Đang giao
                            </option>
                            <option value="Đã giao" {{ $order->order_status == 'Đã giao' ? 'selected' : '' }}>Đã giao
                            </option>
                            <option value="Đã huỷ" {{ $order->order_status == 'Đã huỷ' ? 'selected' : '' }}>Đã huỷ
                            </option>
                        </select>
                    </div>
                    @csrf
                    <button type="submit"
                        style="background-color: #1ab6eb; color: white; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer;">
                        Cập nhật
                    </button>
                </form>
            </div>

            <!-- Right Side: Invoice -->
            <div style="flex: 1; padding: 20px; border: 1px solid #eee; border-radius: 8px;">
                <h2>Hóa đơn bán hàng</h2>
                <p><strong>Mã đơn hàng:</strong> {{ $order->id }}</p>
                <p><strong>Khách hàng:</strong> {{ $customer->name }}</p>
                <p><strong>SDT:</strong> {{ $customer->phone }}</p>
                <p><strong>Ngày đặt hàng:</strong> {{ $order->created_at->format('d-m-Y') }}</p>

                <!-- Product Table -->
                <table class="table"
                    style="width: 100%; line-height: inherit; text-align: left; margin-top: 20px; border-collapse: collapse;">
                    <thead>
                        <tr style="background: #eee; border-bottom: 1px solid #ddd;">
                            <th style="padding: 8px;">Tên sản phẩm</th>
                            <th style="padding: 8px; text-align: right;">Giá</th>
                            <th style="padding: 8px; text-align: center;">Số lượng</th>
                            <th style="padding: 8px; text-align: right;">Tổng</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($orderDetail as $key => $orderdt)
                            @php
                                $price = $orderdt->product->price;
                                $priceEnd = $price * $orderdt->qty;
                            @endphp
                            <tr style="border-bottom: 1px solid #ddd;">
                                <td style="padding: 8px;">{{ $orderdt->product->name }}</td>
                                <td style="padding: 8px; text-align: right;">{{ number_format($price, 0, '', ',') }} đ</td>
                                <td style="padding: 8px; text-align: center;">x{{ $orderdt->qty }}</td>
                                <td style="padding: 8px; text-align: right;">{{ number_format($priceEnd, 0, '.', ',') }} đ
                                </td>
                            </tr>
                        @endforeach
                        <tr>
                            <td colspan="3" style="text-align: right; padding: 8px;"><strong>Giảm giá:</strong></td>
                            <td style="padding: 8px; text-align: right; color: red;">
                                -{{ number_format($order->discount, 0, '.', ',') }} đ</td>
                        </tr>
                        <tr>
                            <td colspan="3" style="text-align: right; padding: 8px;"><strong>Tổng cộng:</strong></td>
                            <td style="padding: 8px; text-align: right;">{{ number_format($order->total, 0, '.', ',') }} đ
                            </td>
                        </tr>
                    </tbody>
                </table>

                <!-- Print Button -->
                @if ($order->order_status == 'Đã giao')
                    <div style="text-align: right; margin-top: 30px;">
                        <a href="/admin/invoice/{{ $order->id }}"
                            style="background-color: #4CAF50; color: white; padding: 15px 30px; border: none; border-radius: 5px; cursor: pointer; 
               font-size: 16px; text-decoration: none; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); transition: background-color 0.3s;">
                            In hoá đơn
                        </a>
                    </div>
                @elseif($order->order_status == 'Chờ xác nhận')
                    <div style="text-align: center; margin-top: 20px;">
                        <i>Đơn hàng đang chờ xác nhận !</i>
                    </div>
                @else
                    <div style="text-align: center; margin-top: 20px;">
                        <i>Đơn hàng đang được giao !</i>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
