        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="/admin/main" class="nav-link">Trang chủ</a>
                </li>
            </ul>

            <!-- SEARCH FORM -->
            {{-- <form class="form-inline ml-3">
                <div class="input-group input-group-sm">
                    <input class="form-control form-control-navbar" type="search" placeholder="Search"
                        aria-label="Search">
                    <div class="input-group-append">
                        <button class="btn btn-navbar" type="submit">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>
            </form> --}}

            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link" data-toggle="dropdown" href="#">
                        <i class="far fa-comments"></i>
                        <span class="badge badge-danger navbar-badge">{{ $msCount }}</span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right" id="messageDropdown">
                        @foreach ($messages as $mes)
                            <!-- Chỉ lấy 4 tin nhắn đầu tiên -->
                            <a href="#" class="dropdown-item">
                                <!-- Message Start -->
                                <div class="media">
                                    <div class="media-body">
                                        <h3 class="dropdown-item-title">
                                            {{ $mes->email }}
                                            <span class="float-right text-sm text-danger"><i
                                                    class="fas fa-star"></i></span>
                                        </h3>
                                        <p class="text-sm">{{ $mes->content }}</p>
                                    </div>
                                </div>
                                <!-- Message End -->
                            </a>
                        @endforeach
                        <div class="dropdown-divider"></div>
                    </div>

                </li>
                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                        <img src="/template/user/images/lv1.jpg" class="user-image" alt="User Image">
                        <span class="hidden-xs">Admin</span>
                    </a>
                    <ul class="dropdown-menu">
                        <!-- User image -->
                        <li class="user-header">
                            <img src="/template/user/images/lv1.jpg" class="img-circle" alt="User Image">
                            <p>LouVu</p>
                        </li>
                        <!-- Menu Footer-->
                        <li class="user-footer">
                            <form action="/admin/users/logout" method="POST">
                                <div class="float-left">
                                    <button type="submit" class="btn btn-default btn-flat">Đăng xuất</button>
                                </div>
                                @csrf
                            </form>
                        </li>
                    </ul>
                </li>

            </ul>
        </nav>
