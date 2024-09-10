<style>
    .wrap-table-shopping-cart {
        overflow-y: auto;
        /* Thêm tính năng cuộn dọc */
        max-height: 600px;
        /* Chiều cao giới hạn để hiển thị khoảng 4 sản phẩm */
        border-left: 1px solid #e6e6e6;
        border-right: 1px solid #e6e6e6;
    }
</style>
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
        <form class="bg0 p-t-40 p-b-60" action="{{ route('apply_discount') }}" method="post">
            <div class="container">
                <div class="row">
                    <div class="col-lg-10 col-xl-7 m-lr-auto m-b-50">
                        <div class="m-l-25 m-r--38 m-lr-0-xl">
                            <div class="wrap-table-shopping-cart">
                                <table class="table-shopping-cart">
                                    <thead>
                                        <tr class="table_head">
                                            <th class="column-1">Sản phẩm</th>
                                            <th class="column-2">Tên sản phẩm</th>
                                            <th class="column-3">Giá</th>
                                            <th class="column-4">Số lượng</th>
                                            <th class="column-5">Thành tiền</th>
                                            <th class="column-6"> </th>
                                        </tr>
                                    </thead>
                                    <tbody>
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
                                                $total = $price_End - $discount + 30000;
                                            @endphp
                                            <tr class="table_row">
                                                <td class="column-1">
                                                    <div class="how-itemcart1">
                                                        <img src="{{ $product->thumb }}" alt="IMG">
                                                    </div>
                                                </td>
                                                <td class="column-2">{{ $product->name }}</td>
                                                <td class="column-3"> <u>đ</u>{!! \App\Helpers\Helper::price($product->price, $product->price_sale) !!} </td>
                                                <td class="column-4">
                                                    <div class="wrap-num-product flex-w m-l-auto m-r-0">
                                                        <div class="btn-num-product-down cl8 hov-btn3 trans-04 flex-c-m">
                                                            <i class="fs-16 zmdi zmdi-minus"></i>
                                                        </div>
                                                        <input class="mtext-104 cl3 txt-center num-product" type="number"
                                                            name="num_product[{{ $product->id }}]"
                                                            value="{{ $carts[$product->id] }}">
                                                        <div class="btn-num-product-up cl8 hov-btn3 trans-04 flex-c-m">
                                                            <i class="fs-16 zmdi zmdi-plus"></i>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="column-5"><u>đ</u>{{ number_format($priceEnd, 0, '.', ',') }}
                                                </td>
                                                <td class="column-6 p-r-15">
                                                    <a href="/delete-cart/{{ $product->id }}"><i
                                                            class="fa-solid fa-trash-can" style="color: red;"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <div class="flex-w flex-sb-m bor15 p-t-18 p-b-15 p-lr-40 p-lr-15-sm">
                                @if ($price_End < 500000)
                                    <div class="flex-w flex-m m-r-20 m-tb-5">
                                        <input class="stext-104 cl2 plh4 size-117 bor13 p-lr-20 m-r-10 m-tb-5"
                                            type="text" name="code" placeholder="mã giảm giá" autocomplete="off">

                                        <input type="submit" value="Áp dụng mã" formaction="{{ route('apply_discount') }}"
                                            class="flex-c-m stext-101 cl2 size-118 bg8 bor13 hov-btn3 p-lr-15 trans-04 pointer m-tb-5">
                                    </div>
                                @else
                                    <span style="color: #4CAF50"><i class="fa-solid fa-check"></i> <i>Đơn hàng của bạn được
                                            miễn phí vận chuyển.</i></span>
                                @endif
                                <input type="submit" value="Cập nhật giỏ hàng" formaction="update-cart"
                                    class="flex-c-m stext-101 cl2 size-119 bg8 bor13 hov-btn3 p-lr-15 trans-04 pointer m-tb-10">
                                @csrf
                                @if (Session::has('discount'))
                                    <span style="color: #4CAF50"><i class="fa-solid fa-check"></i> <i>Đã áp dụng mã giảm
                                            giá.</i></span>
                                @endif
                            </div>

                        </div>
                    </div>

                    <div class="col-sm-10 col-lg-7 col-xl-5 m-lr-auto m-b-50">
                        <div class="bor10 p-lr-40 p-t-30 p-b-40 m-l-63 m-r-40 m-lr-0-xl p-lr-15-sm">
                            <h4 class="mtext-109 cl2 p-b-30" style="text-align: center">
                                Giỏ hàng
                            </h4>
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
                                <span><b>Tổng :</b></span>
                                <span><b><u>đ</u>{{ number_format($total, 0, '.', ',') }}</b></span>
                            </div>
                            <a href="/order-cart"
                                class="flex-c-m stext-101 cl0 size-116 bg3 bor14 hov-btn3 p-lr-15 trans-04 pointer "
                                onclick="" style="margin-top: 20px">
                                Mua hàng
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    @else
        <div class="text-center">
            <h1>Chưa có sản phẩm nào trong giỏ hàng</h1>
        </div>
    @endif
@endsection
