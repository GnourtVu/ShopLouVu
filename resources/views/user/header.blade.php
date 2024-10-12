    <header>
        @php
            $menuHtml = \App\Helpers\Helper::menus($menus);

            // Kiểm tra xem giỏ hàng có tồn tại trong session hay không
            if (Session::get('customerRole')) {
                # code...
                $count = $countCart;
            } else {
                $count = 0;
                $carts = Session::get('carts', []);
                // Duyệt qua từng sản phẩm trong giỏ hàng
                foreach ($carts as $productId => $sizes) {
                    // Duyệt qua từng kích thước
                    foreach ($sizes as $size => $colors) {
                        // Duyệt qua từng màu sắc
                        foreach ($colors as $color => $quantity) {
                            // Cộng dồn số lượng sản phẩm
                            if (is_int($quantity)) {
                                $count += $quantity; // Cộng dồn số lượng sản phẩm
                            }
                        }
                    }
                }
            }

        @endphp

        <!-- Header desktop -->
        <div class="container-menu-desktop">
            <!-- Topbar -->
            <div class="top-bar">
                <div class="content-topbar flex-sb-m h-full container">
                    <div class="left-top-bar marquee">
                        <i>Miễn phí vận chuyển cho đơn hàng trên 500,000đ.</i>
                    </div>
                    <div class="right-top-bar flex-w h-full">
                        <a href="#" class="flex-c-m trans-04 p-lr-25">
                            @if (Session::get('customerRole'))
                                @php
                                    $customer = Session::get('customerRole');
                                @endphp
                                <p><i> {{ $customer->name }}</i></p>
                            @else
                                <p><i>Khách hàng vãng lai</i></p>
                            @endif
                        </a>
                    </div>
                </div>
            </div>

            <div class="wrap-menu-desktop">
                <nav class="limiter-menu-desktop container">

                    <!-- Logo desktop -->
                    <a href="/user" class="logo">
                        <img src="/template/user/images/icons/lv.png" alt="IMG-LOGO">
                    </a>
                    <!-- Menu desktop -->
                    <div class="menu-desktop">
                        <ul class="main-menu">
                            <li>
                                <a href="/user">Trang chủ</a>
                            </li>
                            <li>
                                <a href="/user/shop">Shop</a>
                                {!! $menuHtml !!}
                            </li>
                            <li>
                                <a href="/user/about">Về LouVu</a>
                            </li>

                            <li>
                                <a href="/user/contact">Liên hệ</a>
                            </li>
                        </ul>
                    </div>

                    <!-- Icon header -->
                    <div class="wrap-icon-header flex-w flex-r-m">
                        <div class="icon-header-item cl2 hov-cl1 trans-04 p-l-22 p-r-11 icon-header-noti js-show-cart"
                            data-notify="{{ $count }}">

                            <i class="zmdi zmdi-shopping-cart"></i>
                        </div>
                        <a href="/viewOrder" class="dis-block icon-header-item cl2 hov-cl1 trans-04 p-l-22 p-r-11 ">
                            <i class="fa-solid fa-receipt"></i>
                        </a>
                        @if (!Session::get('customerRole'))
                            <a href="/user/login" class="dis-block icon-header-item cl2 hov-cl1 trans-04 p-l-22 p-r-11">
                                <i class="fa-solid fa-user"></i>
                            </a>
                        @else
                            <div class="user-menu">
                                <a href="#" class="dis-block icon-header-item cl2 hov-cl1 trans-04 p-l-22 p-r-11">
                                    <i class="fa-solid fa-user"></i>
                                </a>
                                <div class="menu-dropdown">
                                    <a href="/user/settings" class="menu-item">Cài đặt</a>
                                    <button class="menu-item" id="logoutBtn" type="button">Đăng xuất</button>
                                    <!-- Thay đổi thành button -->
                                </div>
                            </div>
                        @endif
                        <!-- Modal xác nhận đăng xuất -->
                        <div id="logoutModal" class="modal">
                            <div class="modal-content">
                                <span class="close">&times;</span>
                                <h2>Bạn có chắc muốn đăng xuất không?</h2>
                                <div class="modal-buttons">
                                    <form id="logoutForm" method="POST" action="/user/logout">
                                        @csrf
                                        <button type="submit" class="btn confirm-btn">Đăng xuất</button>
                                    </form>
                                    <button class="btn cancel-btn" id="cancelBtn">Hủy</button>
                                </div>
                            </div>
                        </div>

                    </div>
                </nav>
            </div>
        </div>

        <!-- Header Mobile -->
        <div class="wrap-header-mobile">
            <!-- Logo moblie -->
            <div class="logo-mobile">
                <a href="index.html"><img src="/template/user/images/icons/logo-01.png" alt="IMG-LOGO"></a>
            </div>

            <!-- Icon header -->
            <div class="wrap-icon-header flex-w flex-r-m m-r-15">
                <div class="icon-header-item cl2 hov-cl1 trans-04 p-r-11 p-l-10 icon-header-noti js-show-cart"
                    data-notify="{{ $count }}">
                    <i class="zmdi zmdi-shopping-cart"></i>
                </div>
                <a href="/user/login" class="dis-block icon-header-item cl2 hov-cl1 trans-04 p-l-22 p-r-11 ">
                    <i class="fa-solid fa-user"></i>
                </a>
            </div>

            <!-- Button show menu -->
            <div class="btn-show-menu-mobile hamburger hamburger--squeeze">
                <span class="hamburger-box">
                    <span class="hamburger-inner"></span>
                </span>
            </div>
        </div>


        <!-- Menu Mobile -->
        <div class="menu-mobile">

            <ul class="main-menu-m">
                <li>
                    <a href="/user">Trang chủ</a>
                </li>
                <li>
                    <a href="/user/shop">Shop</a>
                    {!! $menuHtml !!}
                </li>
                <li>
                    <a href="/user/about">Về LouVu</a>
                </li>

                <li>
                    <a href="/user/contact">Liên hệ</a>
                </li>
            </ul>
        </div>
        <!-- Modal Search -->
        {{-- <div class="modal-search-header flex-c-m trans-04 js-hide-modal-search">
            <div class="container-search-header">
                <button class="flex-c-m btn-hide-modal-search trans-04 js-hide-modal-search">
                    <img src="/template/user/images/icons/icon-close2.png" alt="CLOSE">
                </button>

                <form class="wrap-search-header flex-w p-l-15">
                    <button class="flex-c-m trans-04">
                        <i class="zmdi zmdi-search"></i>
                    </button>
                    <input class="plh3" type="text" name="search" placeholder="Search...">
                </form>
            </div>
        </div> --}}
    </header>
    @yield('header')
