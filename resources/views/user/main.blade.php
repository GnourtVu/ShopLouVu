<!DOCTYPE html>
<html lang="en">

<head>
    @include('user.head')
</head>

<body class="animsition">

    <!-- Header -->
    @include('user.header')

    <!-- Cart -->
    @include('user.viewcart')

    <!--Content-->
    @yield('content')


    <!-- Footer -->
    @include('user.footer')


    <!-- Back to top -->
    <div class="btn-back-to-top" id="myBtn">
        <span class="symbol-btn-back-to-top">
            <i class="zmdi zmdi-chevron-up"></i>
        </span>
    </div>

    <!-- Modal1 -->
    <!-- Modal hiển thị bảng kích thước -->
    <div id="sizeChartModal" class="modal" style="display: none;">
        <div class="modal-content">
            <span class="close">&times;</span>
            <img id="sizeChartImage" src="" alt="Bảng kích thước" style="width: 100%; max-width: 600px;">
        </div>
    </div>

    <div class="wrap-modal1 js-modal1 p-t-60 p-b-20">
        <div class="overlay-modal1 js-hide-modal1"></div>
        <form action="/add-cart" method="post">
            <input type="hidden" name="product_id" value="">
            <div class="container">
                <div class="bg0 p-t-60 p-b-30 p-lr-15-lg how-pos3-parent">
                    <button class="how-pos3 hov3 trans-04 js-hide-modal1">
                        <img src="/template/user/images/icons/icon-close.png" alt="CLOSE">
                    </button>
                    <div class="row">
                        <div class="col-md-6 col-lg-7 p-b-30">
                            <div class="p-l-25 p-r-30 p-lr-0-lg">
                                <div class="wrap-slick3 flex-sb flex-w">
                                    <div class="wrap-slick3-dots"></div>
                                    <div class="wrap-slick3-arrows flex-sb-m flex-w"></div>
                                    <div class="slick3 gallery-lb">
                                        <div class="item-slick3" data-thumb="">
                                            <div class="wrap-pic-w pos-relative">
                                                <img src="" alt="IMG-PRODUCT">
                                                <a class="flex-c-m size-108 how-pos1 bor0 fs-16 cl10 bg0 hov-btn3 trans-04"
                                                    href="">
                                                    <i class="fa fa-expand"></i>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="item-slick3" data-thumb="">
                                            <div class="wrap-pic-w pos-relative">
                                                <img src="" alt="IMG-PRODUCT">
                                                <a class="flex-c-m size-108 how-pos1 bor0 fs-16 cl10 bg0 hov-btn3 trans-04"
                                                    href="">
                                                    <i class="fa fa-expand"></i>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="item-slick3" data-thumb="">
                                            <div class="wrap-pic-w pos-relative">
                                                <img src="" alt="IMG-PRODUCT">
                                                <a class="flex-c-m size-108 how-pos1 bor0 fs-16 cl10 bg0 hov-btn3 trans-04"
                                                    href="">
                                                    <i class="fa fa-expand"></i>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="item-slick3" data-thumb="">
                                            <div class="wrap-pic-w pos-relative">
                                                <img src="" alt="IMG-PRODUCT">
                                                <a class="flex-c-m size-108 how-pos1 bor0 fs-16 cl10 bg0 hov-btn3 trans-04"
                                                    href="">
                                                    <i class="fa fa-expand"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-5 p-b-30">
                            <div class="p-r-50 p-t-5 p-lr-0-lg">
                                <h4 class="mtext-105 cl2 js-name-detail p-b-14">
                                </h4>
                                <span class="mtext-106 cl2">
                                </span>
                                <p class="stext-102 cl3 p-t-23">
                                </p>
                                <h5 class="stext-103 cl3 p-t-23">
                                </h5>
                                <div class="p-t-33">
                                    <div class="flex-w flex-r-m p-b-10">
                                        <div class="size-203 flex-c-m respon6">
                                            Color
                                        </div>
                                        <div class="size-204 respon6-next">
                                            <div class="rs1-select2 bor8 bg0">
                                                <select class="js-select2" name="color">
                                                    <option value="">Chọn màu phù hợp</option>
                                                    <option value="Trắng">Trắng</option>
                                                    <option value="Đen">Đen</option>
                                                    <option value="Xanh">Xanh</option>
                                                    <option value="Vàng">Vàng</option>
                                                </select>
                                                <div class="dropDownSelect2"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex-w flex-r-m p-b-10">
                                        <div class="size-203 flex-c-m respon6">
                                            Size
                                        </div>
                                        <div class="size-204 respon6-next">
                                            <div class="rs1-select2 bor8 bg0">
                                                <select class="js-select2" name="size">
                                                    <option value="">Chọn size phù hợp</option>
                                                    <option value="S">S</option>
                                                    <option value="M">M</option>
                                                    <option value="L">L</option>
                                                    <option value="XL">XL</option>
                                                </select>
                                                <div class="dropDownSelect2"></div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="flex-w flex-r-m p-b-10">
                                        <div class="size-204 flex-w flex-m respon6-next">
                                            <div class="wrap-num-product flex-w m-r-20 m-tb-10">
                                                <div class="btn-num-product-down cl8 hov-btn3 trans-04 flex-c-m">
                                                    <i class="fs-16 zmdi zmdi-minus"></i>
                                                </div>
                                                <input class="mtext-104 cl3 txt-center num-product" type="number"
                                                    name="num_product" value="1">
                                                <div class="btn-num-product-up cl8 hov-btn3 trans-04 flex-c-m">
                                                    <i class="fs-16 zmdi zmdi-plus"></i>
                                                </div>
                                            </div>
                                            @csrf
                                            <button type="submit"
                                                class="flex-c-m stext-101 cl0 size-101 bg1 bor1 hov-btn1 p-lr-15 trans-04 js-addcart-detail">
                                                Thêm vào giỏ hàng
                                            </button>

                                        </div>
                                    </div>
                                </div>

                                <!--  -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

    @include('user.foot')
</body>

</html>
