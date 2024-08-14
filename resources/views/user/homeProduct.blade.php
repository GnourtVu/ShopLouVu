@extends('user.main')
@section('content')
    <!-- Slider -->
    @include('user.slider')
    <!-- Banner -->
    @include('user.banner')
    <!-- Product -->
    <div class="why-choose-section m-b-10">
        <div class="container">
            <div class="row justify-content-between">
                <div class="col-lg-6">
                    <h2 class="section-title">Why Choose Us</h2>
                    <p>Chúng tôi cung cấp các dịch vụ tốt nhất với đội ngũ chuyên nghiệp. Đảm bảo sự hài lòng cho quý khách.
                    </p>

                    <div class="row my-5">
                        <div class="col-6 col-md-6">
                            <div class="feature">
                                <div class="icon">
                                    <img src="/template/user/images/icons/truck.svg" alt="Image" class="imf-fluid">
                                </div>
                                <h3>Fast &amp; Free Shipping</h3>
                                <p>Chúng tôi đảm bảo giao hàng nhanh chóng và miễn phí đến tận nơi cho quý khách.
                                </p>
                            </div>
                        </div>

                        <div class="col-6 col-md-6">
                            <div class="feature">
                                <div class="icon">
                                    <img src="/template/user/images/icons/bag.svg" alt="Image" class="imf-fluid">
                                </div>
                                <h3>Easy to Shop</h3>
                                <p>Trải nghiệm mua sắm tiện lợi với nhiều tùy chọn thanh toán và sản phẩm đa dạng.
                                </p>
                            </div>
                        </div>

                        <div class="col-6 col-md-6">
                            <div class="feature">
                                <div class="icon">
                                    <img src="/template/user/images/icons/support.svg" alt="Image" class="imf-fluid">
                                </div>
                                <h3>24/7 Support</h3>
                                <p>Đội ngũ hỗ trợ của chúng tôi sẵn sàng phục vụ quý khách mọi lúc, mọi nơi.
                                </p>
                            </div>
                        </div>

                        <div class="col-6 col-md-6">
                            <div class="feature">
                                <div class="icon">
                                    <img src="/template/user/images/icons/return.svg" alt="Image" class="imf-fluid">
                                </div>
                                <h3>Hassle Free Returns</h3>
                                <p>Chính sách trả hàng linh hoạt giúp quý khách an tâm mua sắm.
                                </p>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="col-lg-5">
                    <div class="img-wrap">
                        <img src="/template/user/images/dior2.jpg" alt="Image" class="img-fluid"
                            style="border-radius: 6%;">
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
