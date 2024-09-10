@extends('user.main')
@section('content')
    <!-- Slider -->
    @include('user.slider')
    <!-- Banner -->
    @include('user.banner')
    <!-- Product -->
    <section class="sec-relate-product bg0 p-t-45 p-b-50">
        <div class="container">
            <div class="p-b-45">
                <h3 class="ltext-106 cl5 txt-center highlight-text">
                    <b style="color: rgb(58, 4, 4)">Sản phẩm ưa chuộng </b>
                    <i style="color: red">Hot sale <i class="fa-solid fa-fire"></i></i>
                </h3>
            </div>
            @include('user.productHot')
        </div>
    </section>
    <!-- Mã Vận Chuyển -->
    <h1 class="voucher-title">
        <i class="fa-solid fa-ticket" style="color: rgb(204, 14, 14)"></i>
        Voucher tặng bạn
        <i class="fa-solid fa-ticket" style="color: rgb(204, 14, 14)"></i>
        <p class="coin-icon">🪙</p>
        <p class="coin-icon">🪙</p>
        <p class="coin-icon">🪙</p>
        <p class="coin-icon">🪙</p>
    </h1>
    <div class="shipping-codes">
        @foreach ($discountCode as $dis)
            <div class="shipping-code-section">
                <div class="shipping-code-container">
                    <div class="shipping-code-text">
                        <span class="shippingCode"><i class="fa-solid fa-truck-fast"
                                style="color: white"></i><i>{{ $dis->code }}</i></span>
                        <span class="discount-name">{{ $dis->name }}</span>
                    </div>
                    <button class="btn-copy" onclick="copyShippingCode(event)">Sao chép </button>
                </div>
            </div>
        @endforeach
    </div>

    <div class="why-choose-section m-b-10 p-t-45">
        <div class="container">
            <div class="row justify-content-between">
                <div class="col-lg-6">
                    <h2 class="section-title">Tại sao nên chọn sản phẩm LouVu ?</h2>
                    <p>Chúng tôi cung cấp các dịch vụ tốt nhất với đội ngũ chuyên nghiệp. Đảm bảo sự hài lòng cho quý khách.
                    </p>

                    <div class="row my-5">
                        <div class="col-6 col-md-6">
                            <div class="feature">
                                <div class="icon">
                                    <img src="/template/user/images/icons/truck.svg" alt="Image" class="imf-fluid">
                                </div>
                                <h3>Nhanh &amp; FreeShip</h3>
                                <p>Chúng tôi đảm bảo giao hàng nhanh chóng và miễn phí đến tận nơi cho quý khách.
                                </p>
                            </div>
                        </div>

                        <div class="col-6 col-md-6">
                            <div class="feature">
                                <div class="icon">
                                    <img src="/template/user/images/icons/bag.svg" alt="Image" class="imf-fluid">
                                </div>
                                <h3>Mua sắm dễ dàng</h3>
                                <p>Trải nghiệm mua sắm tiện lợi với nhiều tùy chọn thanh toán và sản phẩm đa dạng.
                                </p>
                            </div>
                        </div>

                        <div class="col-6 col-md-6">
                            <div class="feature">
                                <div class="icon">
                                    <img src="/template/user/images/icons/support.svg" alt="Image" class="imf-fluid">
                                </div>
                                <h3>24/7 Hỗ trợ</h3>
                                <p>Đội ngũ hỗ trợ của chúng tôi sẵn sàng phục vụ quý khách mọi lúc, mọi nơi.
                                </p>
                            </div>
                        </div>

                        <div class="col-6 col-md-6">
                            <div class="feature">
                                <div class="icon">
                                    <img src="/template/user/images/icons/return.svg" alt="Image" class="imf-fluid">
                                </div>
                                <h3>Hoàn trả linh hoạt</h3>
                                <p>Chính sách trả hàng linh hoạt giúp quý khách an tâm mua sắm.
                                </p>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="col-lg-5">
                    <div class="img-wrap">
                        <img src="/template/user/images/gr1.jpg" alt="Image" class="img-fluid"
                            style="border-radius: 6%;">
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
