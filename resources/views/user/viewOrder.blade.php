@extends('user.main')
@section('content')
    <section class="bg0 p-t-23 p-b-140 p-t-90">
        <form action="/viewOrder" method="post">
            <div class="bg0 m-t-23 p-b-140">
                <div class="container">
                    @if (Session::get('customerRole'))
                        <h3>Đơn hàng của bạn</h3>
                        <div class="order-list mt-4">
                            <div class="orders-container">
                                @foreach ($orders as $order)
                                    <div class="order-info">
                                        <div class="order-header">
                                            <span class="order-id">Mã đơn hàng: {{ $order->id }}</span>
                                            <span class="order-status">Trạng thái: {{ $order->order_status }}</span>
                                        </div>
                                        <div class="order-details">
                                            <span class="order-date">Ngày đặt:
                                                {{ $order->created_at->format('d/m/Y') }}</span>
                                            <span class="order-total">Tổng tiền:
                                                {{ number_format($order->total, 0, ',', '.') }} đ</span>
                                        </div>

                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th>Sản phẩm</th>
                                                    <th>Hình ảnh</th>
                                                    <th>Size</th>
                                                    <th>Màu sắc</th>
                                                    <th>Số lượng</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($order->order_items as $item)
                                                    <tr>
                                                        <td>{{ $item->product->name }}</td>
                                                        <td><img src="{{ $item->product->thumb }}" alt=""
                                                                style="width: 50px;"></td>
                                                        <td>{{ $item->size }}</td>
                                                        <td>{{ $item->color }}</td>
                                                        <td>x{{ $item->qty }}</td>
                                                        <td>
                                                            @if ($order->order_status === 'Đã giao')
                                                                <a
                                                                    href="/product/{{ $item->product->id }}-{{ $item->product->name }}.html">Đánh
                                                                    giá</a>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>

                                        {{-- Nút hủy đơn hàng nếu chưa giao --}}
                                        @if ($order->order_status === 'Chờ xác nhận')
                                            <form action="/cancelOrder/{{ $order->id }}" method="POST"
                                                style="margin-top: 15px;">
                                                @csrf
                                                <input type="hidden" name="order_id" value="{{ $order->id }}">
                                                <button type="submit" class="btn btn-danger">Hủy đơn hàng</button>
                                            </form>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @else
                        <div class="search-od">
                            <p>Tìm kiếm đơn hàng :</p>
                            <div class="search-b">
                                <input type="text" name="orderId" placeholder="Nhập mã đơn hàng" autocomplete="off">
                                <button>
                                    <i class="zmdi zmdi-search"></i>
                                </button>
                                @csrf
                            </div>
                            <div style="width: 30%;margin-top: 10px">@include('admin.alert')</div>
                        </div>
                        @if ($order)
                            <h3>Đơn hàng của bạn</h3>
                            <div class="order-list mt-4">
                                <div class="order-info">
                                    <div class="order-header">
                                        <span class="order-id">Mã đơn hàng: {{ $order->id }}</span>
                                        <span class="order-status">Trạng thái: {{ $order->order_status }}</span>
                                    </div>
                                    <div class="order-details">
                                        <span class="order-date">Ngày đặt: {{ $order->created_at->format('d/m/Y') }}</span>
                                        <span class="order-total">Tổng tiền:
                                            {{ number_format($order->total, 0, ',', '.') }}
                                            đ</span>
                                    </div>
                                </div>
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Sản phẩm</th>
                                            <th>Hình ảnh</th>
                                            <th>Size</th>
                                            <th>Màu sắc</th>
                                            <th>Số lượng</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($orderItem as $item)
                                            <tr>
                                                <td>{{ $item->product->name }}</td>
                                                <td><img src="{{ $item->product->thumb }}" alt=""
                                                        style="width: 50px; ">
                                                </td>
                                                <td>{{ $item->size }}</td>
                                                <td>{{ $item->color }}</td>
                                                <td>x{{ $item->qty }}</td>

                                                <td>
                                                    @if ($order->order_status === 'Đã giao')
                                                        <a
                                                            href="/product/{{ $item->product->id }}-{{ $item->product->name }}.html">Đánh
                                                            giá</a>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    @endif
                </div>
            </div>
        </form>
    </section>
@endsection
