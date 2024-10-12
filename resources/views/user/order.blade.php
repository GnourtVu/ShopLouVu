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
                Thanh toán
            </span>
        </div>
        <div style="width: 30%; padding-top: 10px"> @include('admin.alert')</div>
    </div>
    <!-- shopping cart-->

    @if (count($products) > 0)
        @if (Session::get('customerRole'))
            @php
                $total = 0;
            @endphp
            <form class="bg0 p-t-10 p-b-85" action="/buy-cart" method="post">
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
                                            <input type="text" name="name" value="{{ $customerRl->name }}" readonly>
                                        </div>
                                        <div class="input-group">
                                            <i class="fa-solid fa-phone"></i>
                                            <input type="text" name="phone" value="{{ $customerRl->phone }}" readonly>
                                        </div>
                                        <div class="input-group">
                                            <i class="fa-solid fa-envelope"></i>
                                            <input type="text" name="email" value="{{ $customerRl->email }}" readonly>
                                        </div>
                                        <div>
                                            <h3>Hình thức nhận hàng</h3>
                                            <div> <i class="fa-solid fa-truck-fast"></i> Giao tới nhà,văn phòng(riêng)</div>
                                        </div>
                                        <div class="input-group">
                                            <select id="province" name="province" onchange="fetchDistricts()">
                                                <option value="">Chọn Tỉnh/Thành phố</option>
                                            </select>
                                            <input type="hidden" id="selected-province" name="selected_province">
                                        </div>
                                        <div class="input-group">
                                            <select id="district" name="district" onchange="fetchWards()">
                                                <option value="">Chọn Quận/Huyện</option>
                                            </select>
                                            <input type="hidden" id="selected-district" name="selected_district">
                                        </div>
                                        <div class="input-group">
                                            <select id="ward" name="ward">
                                                <option value="">Chọn Phường/Xã</option>
                                            </select>
                                            <input type="hidden" id="selected-district" name="selected_district">
                                        </div>
                                        <div class="input-group">
                                            <i class="fa-solid fa-location-dot"></i>
                                            <input type="text" name="address"
                                                placeholder="Địa chỉ cụ thể (số nhà/đường ....)">
                                        </div>
                                        <div class="input-group">
                                            <i class="fa-regular fa-note-sticky"></i>
                                            <input type="text" name="content" placeholder="*ghi chú(không bắt buộc)">
                                        </div>
                                        <div class="shipping-method">
                                            <div>Phương thức thanh toán</div>

                                            <div class="option">
                                                <input id="cash" class="cursor-pointer" value="cash" type="radio"
                                                    name="payment" onclick="togglePaymentInfo('cash-info')">
                                                <div>Tiền mặt (COD)</div>
                                                <div class="price"><i class="fa-regular fa-money-bill-1"></i></div>
                                            </div>
                                            <div id="cash-info" class="payment-info" style="display: none;">
                                                <h3>Sử dụng tiền mặt để thanh toán</h3>
                                                <p>Vui lòng thanh toán số tiền sau khi
                                                    sản phẩm được giao tới cho bạn vào khoảng 3-5 ngày làm việc.
                                                </p>
                                            </div>
                                            <div class="option">
                                                <input id="vnpay" class="cursor-pointer" type="radio" value="vnpay"
                                                    name="payment" onclick="togglePaymentInfo('vnpay-info')">
                                                <div>Ví điện tử VNPAY</div>
                                                <div class="price"><img src="/template/user/images/icons/vnicon.jpg"
                                                        alt="VNPAY icon"> </div>
                                            </div>
                                            <div id="vnpay-info" class="payment-info" style="display: none;">
                                                <h3>Sử dụng ví VNPAY để thanh toán</h3>
                                                <p>Vui lòng đảm bảo: bạn đã có tài khoản ví VNPAY đang hoạt động và có đủ số
                                                    dư
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
                                    $price_End = 0;
                                    $priceEnd = 0;
                                    $total = 0;
                                @endphp
                                @foreach ($carts as $cartItem)
                                    @php
                                        $product = $cartItem->product; // Lấy thông tin sản phẩm từ cart_item
                                        $price_End = $product->price * $cartItem->qty;
                                        $priceEnd += $price_End;
                                        if (Session::get('pointOd')) {
                                            $point = Session::get('pointOd');
                                        } else {
                                            $point = 0;
                                        }
                                        if ($priceEnd >= 500000) {
                                            $discount = 30000 + $point;
                                            Session::put('discount', $discount);
                                        } else {
                                            $discount = Session::get('discount') + $point;
                                            Session::put('discount', $discount);
                                        }
                                        $total = $priceEnd + 30000 - $discount; // Cập nhật tổng tiền
                                    @endphp

                                    <!-- Hiển thị thông tin sản phẩm trong giỏ hàng -->
                                    <div class="product-info">
                                        <div>
                                            <img src="{{ $product->thumb }}" alt="Ảnh sản phẩm">
                                        </div>
                                        <div class="product-details">
                                            <div class="product-name">{{ $product->name }} (Size:
                                                {{ $cartItem->size }} - Màu: {{ $cartItem->color }})
                                            </div>
                                            <div>x{{ $cartItem->qty }}</div>
                                            <div class="product-price">
                                                <u>đ</u>{{ number_format($product->price, '0', '.', ',') }}
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                                <!-- Hiển thị tổng thanh toán -->
                                <div class="total-payment">
                                    <span><b>Tổng thanh toán</b></span>
                                    <span><b><u>đ</u>{{ number_format($total, 0, '.', ',') }}</b></span>
                                </div>
                                <!-- Nút thanh toán -->
                                <button class="flex-c-m stext-101 cl0 size-116 bg3 bor14 hov-btn3 p-lr-15 trans-04 pointer"
                                    style="margin-top:10px">
                                    Thanh toán
                                </button>
                                @csrf
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        @else
            @php
                $total = 0;
            @endphp
            <form class="bg0 p-t-10 p-b-85" action="/buy-cart" method="post">
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
                                            <div> <i class="fa-solid fa-truck-fast"></i> Giao tới nhà,văn phòng(riêng)
                                            </div>
                                        </div>
                                        <div class="input-group">
                                            <select id="province" name="province" onchange="fetchDistricts()">
                                                <option value="">Chọn Tỉnh/Thành phố</option>
                                            </select>
                                            <input type="hidden" id="selected-province" name="selected_province">
                                        </div>
                                        <div class="input-group">
                                            <select id="district" name="district" onchange="fetchWards()">
                                                <option value="">Chọn Quận/Huyện</option>
                                            </select>
                                            <input type="hidden" id="selected-district" name="selected_district">
                                        </div>
                                        <div class="input-group">
                                            <select id="ward" name="ward">
                                                <option value="">Chọn Phường/Xã</option>
                                            </select>
                                            <input type="hidden" id="selected-district" name="selected_district">
                                        </div>
                                        <div class="input-group">
                                            <i class="fa-solid fa-location-dot"></i>
                                            <input type="text" name="address"
                                                placeholder="Địa chỉ cụ thể (số nhà/đường ....)">
                                        </div>
                                        <div class="input-group">
                                            <i class="fa-regular fa-note-sticky"></i>
                                            <input type="text" name="content" placeholder="*ghi chú(không bắt buộc)">
                                        </div>
                                        <div class="shipping-method">
                                            <div>Phương thức thanh toán</div>

                                            <div class="option">
                                                <input id="cash" class="cursor-pointer" value="cash"
                                                    type="radio" name="payment"
                                                    onclick="togglePaymentInfo('cash-info')">
                                                <div>Tiền mặt (COD)</div>
                                                <div class="price"><i class="fa-regular fa-money-bill-1"></i></div>
                                            </div>
                                            <div id="cash-info" class="payment-info" style="display: none;">
                                                <h3>Sử dụng tiền mặt để thanh toán</h3>
                                                <p>Vui lòng thanh toán số tiền sau khi
                                                    sản phẩm được giao tới cho bạn vào khoảng 3-5 ngày làm việc.
                                                </p>
                                            </div>

                                            <div class="option">
                                                <input id="vnpay" class="cursor-pointer" type="radio"
                                                    value="vnpay" name="payment"
                                                    onclick="togglePaymentInfo('vnpay-info')">
                                                <div>Ví điện tử VNPAY</div>
                                                <div class="price"><img src="/template/user/images/icons/vnicon.jpg"
                                                        alt="VNPAY icon"> </div>
                                            </div>
                                            <div id="vnpay-info" class="payment-info" style="display: none;">
                                                <h3>Sử dụng ví VNPAY để thanh toán</h3>
                                                <p>Vui lòng đảm bảo: bạn đã có tài khoản ví VNPAY đang hoạt động và có đủ số
                                                    dư
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
                                <!-- Lặp qua các sản phẩm trong giỏ hàng -->
                                @foreach ($products as $product)
                                    @php
                                        $price = $product->price;
                                        // Kiểm tra sản phẩm có trong giỏ hàng không
                                        if (isset($carts[$product->id]) && is_array($carts[$product->id])) {
                                            foreach ($carts[$product->id] as $size => $colors) {
                                                foreach ($colors as $color => $quantity) {
                                                    $priceEnd = $price * $quantity; // Tính giá trị theo số lượng
                                                    $price_End += $priceEnd; // Cộng dồn vào tổng giá trị sản phẩm
                                                }
                                            }
                                        }
                                        // Kiểm tra và áp dụng chiết khấu
                                        if ($price_End >= 500000) {
                                            $discount = 30000;
                                            Session::put('discount', $discount);
                                        } else {
                                            $discount = Session::get('discount');
                                        }
                                        $total = $price_End + 30000 - $discount;
                                    @endphp
                                    <!-- Hiển thị thông tin sản phẩm trong giỏ hàng -->
                                    @if (isset($carts[$product->id]) && is_array($carts[$product->id]))
                                        @foreach ($carts[$product->id] as $size => $colors)
                                            @foreach ($colors as $color => $quantity)
                                                <div class="product-info">
                                                    <div>
                                                        <img src="{{ $product->thumb }}" alt="Ảnh sản phẩm">
                                                    </div>
                                                    <div class="product-details">
                                                        <div class="product-name">{{ $product->name }} (Size:
                                                            {{ $size }} - Màu: {{ $color }})
                                                        </div>
                                                        <div>x{{ $quantity }}</div>
                                                        <div class="product-price">
                                                            <u>đ</u>{{ number_format($product->price, '0', '.', ',') }}
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        @endforeach
                                    @endif
                                @endforeach
                                @php
                                    // Tính tổng thanh toán bao gồm chiết khấu và phí vận chuyển
                                    $total = $price_End - $discount + 30000;
                                    Session(['total' => $total]);
                                @endphp
                                <!-- Hiển thị tổng thanh toán -->
                                <div class="total-payment">
                                    <span><b>Tổng thanh toán</b></span>
                                    <span><b><u>đ</u>{{ number_format($total, 0, '.', ',') }}</b></span>
                                </div>
                                <!-- Nút thanh toán -->
                                <button class="flex-c-m stext-101 cl0 size-116 bg3 bor14 hov-btn3 p-lr-15 trans-04 pointer"
                                    style="margin-top:10px">
                                    Thanh toán
                                </button>
                                @csrf
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        @endif
    @else
        <section class="sec-relate-product bg0 p-t-45 p-b-50">
            <div class="container">
                <div class="p-b-45">
                    <h3 class="ltext-106 cl5 txt-center highlight-text">
                        <b style="color: rgb(58, 4, 4)">Gợi ý sản phẩm </b>
                        <i style="color: red">(Áo thun)</i>
                    </h3>
                </div>
                @include('user.product')
            </div>
        </section>
    @endif
@endsection
