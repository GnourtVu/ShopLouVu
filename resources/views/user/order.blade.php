@extends('user.main')
@section('content')
    <!-- breadCum-->
    <div class="container p-t-90">
        <div class="bread-crumb flex-w p-l-25 p-r-15 p-t-30 p-lr-0-lg">
            <a href="/user" class="stext-109 cl8 hov-cl1 trans-04">
                Trang chủ
                <i class="fa fa-angle-right m-l-9 m-r-10" aria-hidden="true"></i>
            </a>

            <span class="stext-109 cl4">
                Giỏ hàng
            </span>
        </div>
        @include('admin.alert')
    </div>
    <!-- shopping cart-->

    @if (count($products) != 0)
        @php
            $total = 0;
        @endphp
        <form class="bg0 p-t-75 p-b-85" action="/buy-cart" method="post">

            <div class="container">
                <div class="row">
                    <div class="col-lg-10 col-xl-7 m-lr-auto m-b-50">
                        <div class="m-l-25 m-r--38 m-lr-0-xl">
                            <div class="wrap-table-shopping-cart">
                                <div>
                                    <div>
                                        <h3><b>Người nhận</b></h3>
                                    </div>
                                    <div class="input-group">
                                        <i class="fa-solid fa-user"></i>
                                        <input type="text" name="name" placeholder="Tên khách hàng">
                                    </div>
                                    <div class="input-group">
                                        <i class="fa-solid fa-phone"></i>
                                        <input type="text" name="phone" placeholder="Số điện thoại">
                                    </div>
                                    <div class="input-group">
                                        <i class="fa-solid fa-envelope"></i>
                                        <input type="text" name="email" placeholder="Địa chỉ email">
                                    </div>
                                    <div>
                                        <h3>Hình thức nhận hàng</h3>
                                        <div> <i class="fa-solid fa-truck-fast"></i> Giao tới nhà </div>
                                    </div>
                                    <div class="input-group">
                                        <i class="fa-solid fa-location-dot"></i>
                                        <input type="text" name="address" placeholder="Địa chỉ">
                                    </div>
                                    <div class="input-group">
                                        <i class="fa-regular fa-note-sticky"></i>
                                        <input type="text" name="content" placeholder="*ghi chú(không bắt buộc)">
                                    </div>
                                    <div class="shipping-method">
                                        <div>Phương thức thanh toán</div>

                                        <div class="option">
                                            <input id="cash" class="cursor-pointer" type="radio" name="payment"
                                                onclick="togglePaymentInfo('cash-info')">
                                            <div>Tiền mặt (COD)</div>
                                            <div class="price"><i class="fa-regular fa-money-bill-1"></i></div>
                                        </div>
                                        <div id="cash-info" class="payment-info" style="display: none;">
                                            <h3>Sử dụng tiền mặt để thanh toán</h3>
                                            <p>Vui lòng thanh toán số tiền sau khi
                                                sản phẩm được giao tới cho bạn vào khoảng 3-5 ngày làm việc.</p>
                                        </div>

                                        <div class="option">
                                            <input id="vnpay" class="cursor-pointer" type="radio" name="payment"
                                                onclick="togglePaymentInfo('vnpay-info')">
                                            <div>Ví điện tử VNPAY</div>
                                            <div class="price"><img src="/template/user/images/icons/vnicon.jpg"
                                                    alt="VNPAY icon"> </div>
                                        </div>
                                        <div id="vnpay-info" class="payment-info" style="display: none;">
                                            <h3>Sử dụng ví VNPAY để thanh toán</h3>
                                            <p>Vui lòng đảm bảo: bạn đã có tài khoản ví VNPAY đang hoạt động và có đủ số dư
                                                trong tài khoản.</p>
                                        </div>
                                    </div>

                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="col-sm-10 col-lg-7 col-xl-5 m-lr-auto m-b-50">
                        <div class="bor10 p-lr-40 p-t-30 p-b-40 m-l-63 m-r-40 m-lr-0-xl p-lr-15-sm">

                            <h4 class="mtext-109 cl2 p-b-30" style="text-align: center">
                                Chi tiết đơn hàng
                            </h4>
                            @php
                                $total = 0;
                                $priceEnd = 0;
                                $price_End = 0;
                            @endphp
                            @foreach ($products as $key => $product)
                                @php
                                    $price = $product->price;
                                    $priceEnd = $price * $carts[$product->id];
                                    $price_End += $priceEnd;
                                    if ($price_End >= 500000) {
                                        $discount = 30000;
                                    } else {
                                        $discount = Session::get('discount', 0);
                                    }

                                @endphp
                                <div class="product-info">
                                    <div>
                                        <img src="{{ $product->thumb }}" alt="Ảnh sản phẩm">
                                    </div>
                                    <div class="product-details">
                                        <div class="product-name">{{ $product->name }}</div>
                                        <div>x{{ $carts[$product->id] }}</div>
                                        <div class="product-price">
                                            <u>đ</u>{{ number_format($product->price, '0', '.', ',') }}
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                            @php
                                $total = $price_End - $discount + 30000;
                                Session(['total' => $total]);
                            @endphp
                            <div class="cart-detail">
                                <div class="flex items-center justify-between"><span>Tổng giá trị
                                        sản phẩm</span><span><u>đ</u>{{ number_format($price_End, 0, '.', ',') }}</span>
                                </div>
                                <div class="flex items-center justify-between"><span>Vận
                                        chuyển</span><span><u>đ</u>30.000</span></div>
                                <div class="flex items-center justify-between"><span>Giảm giá vận
                                        chuyển</span><span class="discount">-
                                        <u>đ</u>{{ number_format($discount, 0, '.', ',') }}</span></div>
                            </div>
                            <div class="total-payment">
                                <span><b>Tổng thanh toán</b></span>
                                <span><b><u>đ</u>{{ number_format($total, 0, '.', ',') }}</b></span>
                            </div>
                            <button class="flex-c-m stext-101 cl0 size-116 bg3 bor14 hov-btn3 p-lr-15 trans-04 pointer">
                                Thanh toán
                            </button>
                            @csrf
                        </div>
                    </div>
                </div>
            </div>

        </form>
    @else
        {{-- <div class="text-center">
            <h1>Chưa có sản phẩm nào được mua.</h1>
        </div> --}}
    @endif
@endsection
