    <footer class="bg3 p-t-75 p-b-32">
        <div class="container">
            <div class="row">
                <div class="col-sm-6 col-lg-3 p-b-50">
                    <h4 class="stext-301 cl0 p-b-30">
                        Danh mục
                    </h4>
                    <ul>
                        @foreach ($menus as $menu)
                            <li class="p-b-10">
                                <a href="/categories/{{ $menu->id }}-{{ $menu->name }}.html"
                                    class="stext-107 cl7 hov-cl1 trans-04">
                                    {{ $menu->name }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>

                <div class="col-sm-6 col-lg-3 p-b-50">
                    <h4 class="stext-301 cl0 p-b-30">
                        Dịch vụ khách hàng
                    </h4>

                    <ul>
                        <li class="p-b-10">
                            <a href="#" class="stext-107 cl7 hov-cl1 trans-04">
                                Thanh toán
                            </a>
                        </li>

                        <li class="p-b-10">
                            <a href="#" class="stext-107 cl7 hov-cl1 trans-04">
                                Hoàn trả
                            </a>
                        </li>

                        <li class="p-b-10">
                            <a href="#" class="stext-107 cl7 hov-cl1 trans-04">
                                Vẫn chuyển
                            </a>
                        </li>

                        <li class="p-b-10">
                            <a href="#" class="stext-107 cl7 hov-cl1 trans-04">
                                Đối tác
                            </a>
                        </li>
                    </ul>
                </div>

                <div class="col-sm-6 col-lg-3 p-b-50">
                    <h4 class="stext-301 cl0 p-b-30">
                        LouVu lắng nghe bạn
                    </h4>
                    <p class="stext-107 cl7 size-201">
                        Còn thắc mắc gì về LouVu ? Liên hệ trực tiếp với chúng tôi tại tầng 2,88 Tây Lai Xá,Kim
                        Chung-Hoai Duc-Ha Noi.SDT:0866805261
                    </p>

                    <div class="p-t-27">
                        <a href="https://www.facebook.com/trlovu" class="fs-18 cl7 hov-cl1 trans-04 m-r-16">
                            <i class="fa-brands fa-facebook"></i>
                        </a>

                        <a href="https://www.instagram.com/imd_trzg/" class="fs-18 cl7 hov-cl1 trans-04 m-r-16">
                            <i class="fa-brands fa-instagram"></i>
                        </a>
                    </div>
                </div>

                <div class="col-sm-6 col-lg-3 p-b-50">
                    <h4 class="stext-301 cl0 p-b-30">
                        Trở thành đối tác của LouVu
                    </h4>

                    <form>
                        <div class="wrap-input1 w-full p-b-4">
                            <input class="input1 bg-none plh1 stext-107 cl7" type="text" name="email"
                                placeholder="trlovu24@gmail.com">
                            <div class="focus-input1 trans-04"></div>
                        </div>

                        <div class="p-t-18">
                            <button class="flex-c-m stext-101 cl0 size-103 bg1 bor1 hov-btn2 p-lr-15 trans-04">
                                Liên hệ ngay
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="p-t-40">
                <div class="flex-c-m flex-w p-b-18">
                    <a href="#" class="m-all-1">
                        <img src="/template/user/images/icons/icon-pay-01.png" alt="ICON-PAY">
                    </a>

                    <a href="#" class="m-all-1">
                        <img src="/template/user/images/icons/icon-pay-02.png" alt="ICON-PAY">
                    </a>

                    <a href="#" class="m-all-1">
                        <img src="/template/user/images/icons/icon-pay-03.png" alt="ICON-PAY">
                    </a>

                    <a href="#" class="m-all-1">
                        <img src="/template/user/images/icons/icon-pay-04.png" alt="ICON-PAY">
                    </a>

                    <a href="#" class="m-all-1">
                        <img src="/template/user/images/icons/icon-pay-05.png" alt="ICON-PAY">
                    </a>
                </div>

                <p class="stext-107 cl6 txt-center">
                    Made with <i class="fa fa-heart-o" aria-hidden="true"></i> by <a
                        href="https://www.facebook.com/trlovu" target="_blank">Trlovu</a>

                    <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->

                </p>
            </div>
        </div>
    </footer>
    @yield('footer')
