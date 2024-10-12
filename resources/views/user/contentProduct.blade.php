@extends('user.main')
@section('content')
    <div class="container p-t-90">
        <div class="bread-crumb flex-w p-l-25 p-r-15 p-t-30 p-lr-0-lg">
            <a href="/user" class="stext-109 cl8 hov-cl1 trans-04">
                Trang chủ
                <i class="fa fa-angle-right m-l-9 m-r-10" aria-hidden="true"></i>
            </a>
            <a href="/categories/{{ $productDt->menu->id }}-{{ $productDt->menu->name }}.html"
                class="stext-109 cl8 hov-cl1 trans-04">
                {{ $productDt->menu->name }}
                <i class="fa fa-angle-right m-l-9 m-r-10" aria-hidden="true"></i>
            </a>
            <span class="stext-109 cl4">
                {{ $productDt->name }}
            </span>
        </div>
        <div style="margin-top: 10px"> @include('admin.alert')</div>
    </div>
    <!-- product details-->
    <section class="sec-product-detail bg0 p-t-20 p-b-40">
        <div class="container">
            <div class="bg0 p-t-30 p-b-30 p-lr-15-lg how-pos3-parent">
                <button class="how-pos3 hov3 trans-04 js-hide-modal1"> <img src="/template/user/images/icons/icon-close.png"
                        alt="CLOSE"> </button>
                <div class="row">
                    <div class="col-md-6 col-lg-7 p-b-30">
                        <div class="p-l-25 p-r-30 p-lr-0-lg">
                            <div class="wrap-slick3 flex-sb flex-w">
                                <div class="wrap-slick3-dots"></div>
                                <div class="wrap-slick3-arrows flex-sb-m flex-w"></div>
                                <div class="slick3 gallery-lb">
                                    <div class="item-slick3" data-thumb="{{ $productDt->thumb }}">
                                        <div class="wrap-pic-w pos-relative"> <img src="{{ $productDt->thumb }}"
                                                alt="IMG-PRODUCT"> <a
                                                class="flex-c-m size-108 how-pos1 bor0 fs-16 cl10 bg0 hov-btn3 trans-04"
                                                href="{{ $productDt->thumb }}"> <i class="fa fa-expand"></i> </a> </div>
                                    </div>
                                    <div class="item-slick3" data-thumb="{{ $productDt->image1 }}">
                                        <div class="wrap-pic-w pos-relative"> <img src="{{ $productDt->image1 }}"
                                                alt="IMG-PRODUCT"> <a
                                                class="flex-c-m size-108 how-pos1 bor0 fs-16 cl10 bg0 hov-btn3 trans-04"
                                                href="{{ $productDt->image1 }}"> <i class="fa fa-expand"></i> </a> </div>
                                    </div>
                                    <div class="item-slick3" data-thumb="{{ $productDt->image2 }}">
                                        <div class="wrap-pic-w pos-relative"> <img src="{{ $productDt->image2 }}"
                                                alt="IMG-PRODUCT"> <a
                                                class="flex-c-m size-108 how-pos1 bor0 fs-16 cl10 bg0 hov-btn3 trans-04"
                                                href="{{ $productDt->image2 }}"> <i class="fa fa-expand"></i> </a> </div>
                                    </div>
                                    <div class="item-slick3" data-thumb="{{ $productDt->image3 }}">
                                        <div class="wrap-pic-w pos-relative"> <img src="{{ $productDt->image3 }}"
                                                alt="IMG-PRODUCT"> <a
                                                class="flex-c-m size-108 how-pos1 bor0 fs-16 cl10 bg0 hov-btn3 trans-04"
                                                href="{{ $productDt->image3 }}"> <i class="fa fa-expand"></i> </a> </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-5 p-b-30">
                        <div class="p-r-50 p-t-5 p-lr-0-lg">
                            <h4 class="mtext-105 cl2 js-name-detail p-b-14">
                                {{ $productDt->name }}
                            </h4>
                            <span class="mtext-106 cl2">
                                <u>đ</u>{!! \App\Helpers\Helper::price($productDt->price, $productDt->price_sale) !!}
                            </span>
                            <span class="fs-18 cl11">
                                <!-- Hiển thị số sao dựa trên giá trị rating -->
                                @for ($i = 1; $i <= 5; $i++)
                                    @if ($i <= floor($starTb))
                                        <!-- Sao đầy -->
                                        <i class="zmdi zmdi-star"></i>
                                    @elseif($i == ceil($starTb))
                                        <!-- Sao nửa -->
                                        <i class="zmdi zmdi-star-half"></i>
                                    @else
                                        <!-- Sao trống -->
                                        <i class="zmdi zmdi-star-outline"></i>
                                    @endif
                                @endfor
                            </span>
                            <p class="stext-102 cl3 p-t-23">
                                <b> {{ $productDt->description }}</b>
                            </p>
                            <p class="stext-102 cl3 p-t-23">
                                Chỉ còn <b>{{ $productDt->qty_stock }}</b> sản phẩm trong kho .
                                <span style="color: rgb(164, 17, 17)"><i> <b>{{ $productDt->total_qty }} </b>Đã
                                        bán.</i></span>
                            </p>
                            <!--  -->
                            <form action="/add-cart" method="post">
                                <div class="flex-w flex-r-m p-b-10">
                                    <div class="size-203 flex-c-m respon6"> Color </div>
                                    <div class="size-204 respon6-next">
                                        <div class="rs1-select2 bor8 bg0">
                                            <select class="js-select2" name="color" id="colorSelect">
                                                <option>Chọn màu phù hợp</option>
                                                @foreach ($colors as $color)
                                                    <option value="{{ $color->name }}">{{ $color->name }}</option>
                                                @endforeach
                                            </select>
                                            <div class="dropDownSelect2"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="flex-w flex-r-m p-b-10">
                                    <div class="size-203 flex-c-m respon6"> Size </div>
                                    <div class="size-204 respon6-next">
                                        <div class="rs1-select2 bor8 bg0">
                                            <select class="js-select2" name="size" id="sizeSelect">
                                                <option>Chọn size phù hợp</option>
                                                @foreach ($sizes as $size)
                                                    <option value="{{ $size->name }}">{{ $size->name }}</option>
                                                @endforeach
                                            </select>
                                            <div class="dropDownSelect2"></div>
                                        </div>

                                    </div>
                                </div>
                                <div style="margin-left: 100px"><a href="javascript:void(0);" id="showSizeChart"
                                        style="color: rgb(197, 44, 72)">
                                        <i class="fa-solid fa-ruler"></i> Bảng kích thước
                                    </a></div>
                                <div class="product-quantity" style="margin-left: 40px">
                                    <p>Số lượng còn : <span id="productQuantity"><i> (size & color)</i></span></p>
                                </div>
                                <div class="flex-w flex-r-m p-b-10">
                                    <div class="size-204 flex-w flex-m respon6-next">
                                        <div class="wrap-num-product flex-w m-r-20 m-tb-10">
                                            <div class="btn-num-product-down cl8 hov-btn3 trans-04 flex-c-m"> <i
                                                    class="fs-16 zmdi zmdi-minus"></i> </div> <input
                                                class="mtext-104 cl3 txt-center num-product" type="number"
                                                name="num_product" value="1">
                                            <div class="btn-num-product-up cl8 hov-btn3 trans-04 flex-c-m"> <i
                                                    class="fs-16 zmdi zmdi-plus"></i> </div>
                                        </div> @csrf <button type="submit"
                                            class="flex-c-m stext-101 cl0 size-101 bg1 bor1 hov-btn1 p-lr-15 trans-04 js-addcart-detail">
                                            Thêm vào giỏ hàng </button>
                                        <input type="hidden" name="product_id" value="{{ $productDt->id }}">
                                    </div>
                                </div>
                        </div> <!--  -->
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="bor10 m-t-50 p-t-43 p-b-40">
            <!-- Tab01 -->
            <div class="tab01">
                <!-- Nav tabs -->
                <ul class="nav nav-tabs" role="tablist">
                    <li class="nav-item p-b-10">
                        <a class="nav-link active" data-toggle="tab" href="#description" role="tab">Mô tả</a>
                    </li>
                    <li class="nav-item p-b-10">
                        <a class="nav-link" data-toggle="tab" href="#reviews" role="tab">Đánh
                            giá({{ $rvCount }})</a>
                    </li>
                </ul>

                <!-- Tab panes -->
                <div class="tab-content p-t-30">
                    <!-- - -->
                    <div class="tab-pane fade show active" id="description" role="tabpanel">
                        <div class="how-pos2 p-lr-15-md">
                            <p class="stext-102 cl6">
                                {!! $productDt->content !!}
                            </p>
                        </div>
                    </div>
                    <!-- - -->
                    <div class="tab-pane fade" id="reviews" role="tabpanel">
                        <div class="row">
                            <div class="col-sm-10 col-md-8 col-lg-6 m-lr-auto">
                                @if ($customerRv)
                                    @foreach ($rvList as $rv)
                                        <div class="p-b-30 m-lr-15-sm">
                                            <div class="flex-w flex-t p-b-20">
                                                <div class="size-207">
                                                    <div class="flex-w flex-sb-m p-b-17">
                                                        <span class="mtext-107 cl2 p-r-20">
                                                            {{ $rv->customer->name }}
                                                        </span>
                                                        <span class="fs-18 cl11">
                                                            <!-- Hiển thị số sao dựa trên giá trị rating -->
                                                            @for ($i = 1; $i <= 5; $i++)
                                                                @if ($i <= floor($rv->rating))
                                                                    <!-- Sao đầy -->
                                                                    <i class="zmdi zmdi-star"></i>
                                                                @elseif($i == ceil($rv->rating))
                                                                    <!-- Sao nửa -->
                                                                    <i class="zmdi zmdi-star-half"></i>
                                                                @else
                                                                    <!-- Sao trống -->
                                                                    <i class="zmdi zmdi-star-outline"></i>
                                                                @endif
                                                            @endfor
                                                        </span>
                                                    </div>
                                                    <p class="stext-102 cl6">
                                                        {{ $rv->content }}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <div>
                                        <p>Chưa có đánh giá</p>
                                    </div>
                                @endif

                                <!-- Add review -->
                                @if (Session::get('customerRole'))
                                    <form id="reviewForm" class="w-full" action="/review/{{ $productDt->id }}"
                                        method="POST">
                                        <h5 class="mtext-108 cl2 p-b-7">
                                            Đánh giá sản phẩm
                                        </h5>
                                        <div class="flex-w flex-m p-t-20 p-b-23">
                                            <span class="stext-102 cl3 m-r-16">
                                                Đánh giá
                                            </span>
                                            <span class="wrap-rating fs-18 cl11 pointer">
                                                <i class="item-rating pointer zmdi zmdi-star-outline"></i>
                                                <i class="item-rating pointer zmdi zmdi-star-outline"></i>
                                                <i class="item-rating pointer zmdi zmdi-star-outline"></i>
                                                <i class="item-rating pointer zmdi zmdi-star-outline"></i>
                                                <i class="item-rating pointer zmdi zmdi-star-outline"></i>
                                                <input class="dis-none" type="number" name="rating">
                                            </span>
                                        </div>
                                        <div class="row p-b-25">
                                            <div class="col-12 p-b-5">
                                                <label class="stext-102 cl3" for="contentRv">Đánh giá của bạn</label>
                                                <textarea class="size-110 bor8 stext-102 cl2 p-lr-20 p-tb-10" id="content" name="content"></textarea>
                                            </div>
                                            <div class="col-sm-6 p-b-5">
                                                <label class="stext-102 cl3" for="email">Email</label>
                                                <input class="size-111 bor8 stext-102 cl2 p-lr-20" id="email"
                                                    type="email" name="email" value="{{ $customerRl->email }}"
                                                    readonly>
                                            </div>
                                            <div class="col-sm-6 p-b-5">
                                                <label class="stext-102 cl3" for="name">Số điện thoại</label>
                                                <input class="size-111 bor8 stext-102 cl2 p-lr-20" id="phone"
                                                    type="text" name="phone" value="{{ $customerRl->phone }}"
                                                    readonly>
                                            </div>
                                        </div>
                                        @csrf
                                        <button
                                            class="flex-c-m stext-101 cl0 size-112 bg7 bor11 hov-btn3 p-lr-15 trans-04 m-b-10"
                                            type="submit">
                                            Gửi
                                        </button>
                                    </form>
                                @else
                                    <form id="reviewForm" class="w-full" action="/review/{{ $productDt->id }}"
                                        method="POST">
                                        <h5 class="mtext-108 cl2 p-b-7">
                                            Đánh giá sản phẩm
                                        </h5>
                                        <div class="flex-w flex-m p-t-20 p-b-23">
                                            <span class="stext-102 cl3 m-r-16">
                                                Đánh giá
                                            </span>
                                            <span class="wrap-rating fs-18 cl11 pointer">
                                                <i class="item-rating pointer zmdi zmdi-star-outline"></i>
                                                <i class="item-rating pointer zmdi zmdi-star-outline"></i>
                                                <i class="item-rating pointer zmdi zmdi-star-outline"></i>
                                                <i class="item-rating pointer zmdi zmdi-star-outline"></i>
                                                <i class="item-rating pointer zmdi zmdi-star-outline"></i>
                                                <input class="dis-none" type="number" name="rating">
                                            </span>
                                        </div>
                                        <div class="row p-b-25">
                                            <div class="col-12 p-b-5">
                                                <label class="stext-102 cl3" for="contentRv">Đánh giá của bạn</label>
                                                <textarea class="size-110 bor8 stext-102 cl2 p-lr-20 p-tb-10" id="content" name="content"></textarea>
                                            </div>
                                            <div class="col-sm-6 p-b-5">
                                                <label class="stext-102 cl3" for="email">Email</label>
                                                <input class="size-111 bor8 stext-102 cl2 p-lr-20" id="email"
                                                    type="email" name="email">
                                            </div>
                                            <div class="col-sm-6 p-b-5">
                                                <label class="stext-102 cl3" for="name">Số điện thoại</label>
                                                <input class="size-111 bor8 stext-102 cl2 p-lr-20" id="phone"
                                                    type="text" name="phone">
                                            </div>
                                        </div>
                                        @csrf
                                        <button
                                            class="flex-c-m stext-101 cl0 size-112 bg7 bor11 hov-btn3 p-lr-15 trans-04 m-b-10"
                                            type="submit">
                                            Gửi
                                        </button>
                                    </form>
                                @endif

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
        <div class="bg6 flex-c-m flex-w size-302 m-t-73 p-tb-15">
            <span class="stext-107 cl6 p-lr-25">
                Mã sản phẩm : {{ $productDt->id }}
            </span>

            <span class="stext-107 cl6 p-lr-25">
                Danh mục: {{ $productDt->menu->name }}
            </span>
        </div>
    </section>
    <section class="sec-relate-product bg0 p-t-45 p-b-105">
        <div class="container">
            <div class="p-b-45">
                <h3 class="ltext-106 cl5 txt-center">
                    Sản phẩm liên quan
                </h3>
            </div>

            <!-- Slide2 -->
            @include('user.product')
        </div>
    </section>
    <script>
        var reviewUrl = "{{ route('review.store', $productDt->id) }}";
    </script>
@endsection
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('#colorSelect, #sizeSelect').change(function() {
            var sizeName = $('#sizeSelect').val();
            var colorName = $('#colorSelect').val();
            var productId = '{{ $productDt->id }}';

            if (sizeName && colorName) {
                $.ajax({
                    url: '{{ route('getProductQuantityByName') }}',
                    type: 'GET',
                    data: {
                        size_name: sizeName,
                        color_name: colorName,
                        product_id: productId
                    },
                    success: function(response) {
                        $('#productQuantity').text(response.qty);
                    },
                    error: function() {
                        $('#productQuantity').text('0');
                    }
                });
            }
        });
    });
</script>
