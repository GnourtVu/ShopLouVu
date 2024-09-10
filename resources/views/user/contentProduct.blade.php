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
        @include('admin.alert')
    </div>
    <!-- product details-->
    <section class="sec-product-detail bg0 p-t-30 p-b-40">
        <div class="container">
            <div class="bg0 p-t-60 p-b-30 p-lr-15-lg how-pos3-parent">
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

                            <p class="stext-102 cl3 p-t-23">
                                <b> {{ $productDt->description }}</b>
                            </p>
                            <p class="stext-102 cl3 p-t-23">

                                Chỉ còn <b>{{ $productDt->qty_stock }}</b> sản phẩm trong kho .
                            </p>
                            <!--  -->
                            <div class="p-t-33">
                                <div class="flex-w flex-r-m p-b-10">
                                    <div class="size-203 flex-c-m respon6"> Size </div>
                                    <div class="size-204 respon6-next">
                                        <div class="rs1-select2 bor8 bg0"> <select class="js-select2" name="time">
                                                <option>Chọn size phù hợp</option>
                                                <option>Size S</option>
                                                <option>Size M</option>
                                                <option>Size L</option>
                                                <option>Size XL</option>
                                            </select>
                                            <div class="dropDownSelect2"></div>
                                        </div>
                                        <a href="javascript:void(0);" id="showSizeChart" style="color: rgb(197, 44, 72)">
                                            <i class="fa-solid fa-ruler"></i> Bảng kích thước
                                        </a>
                                    </div>
                                </div>
                                <div class="flex-w flex-r-m p-b-10">
                                    <form action="/add-cart" method="post">
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
                                    </form>
                                </div>
                            </div> <!--  -->
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
                    </ul>

                    <!-- Tab panes -->
                    <div>
                        <!-- - -->
                        <div class="tab-pane fade show active" id="description" role="tabpanel">
                            <div class="how-pos2 p-lr-15-md">
                                <p class="stext-102 cl6">
                                    {!! $productDt->content !!}
                                </p>
                            </div>
                        </div>

                        <!-- - -->
                        <!-- - -->

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
@endsection
