<!DOCTYPE html>
<html>

<head>
    @include('admin.head')
    <style>
        /* Đảm bảo các nút nằm ở đúng vị trí */
        .user-menu .user-footer {
            display: flex;
            justify-content: space-between;
            padding: 10px;
        }

        /* Thiết kế nút trong footer */
        .user-menu .user-footer .btn {
            border-radius: 2px;
            background-color: #f4f4f4;
            color: #333;
            width: 100px;
            /* Bạn có thể tùy chỉnh độ rộng nút theo ý muốn */
        }

        /* Đảm bảo ảnh người dùng được căn chỉnh và bo tròn */
        .user-menu .user-image,
        .user-menu .img-circle {
            border-radius: 50%;
            width: 45px;
            height: 45px;
            object-fit: cover;
        }

        /* Nền và căn chỉnh văn bản trong dropdown header */
        .user-menu .user-header {
            background-color: #3c8dbc;
            text-align: center;
            padding: 10px;
            color: #fff;
        }

        .user-menu .user-header p {
            margin-top: 10px;
            font-size: 18px;
        }

        /* Đảm bảo rằng các phần tử user-menu có chiều cao đồng nhất với các phần tử dropdown khác */
        .navbar-nav>.user-menu>.dropdown-toggle,
        .navbar-nav>.nav-item>.nav-link {
            padding-top: 10px;
            padding-bottom: 10px;
            height: auto;
            display: flex;
            align-items: center;
        }

        /* Đảm bảo các ảnh người dùng không làm thay đổi chiều cao của navbar */
        .user-menu .user-image {
            margin-right: 5px;
        }

        /* Tùy chọn để giảm khoảng cách giữa các mục trong navbar */
        .navbar-nav>.user-menu>.dropdown-menu {
            margin-top: 0;
            margin-bottom: 0;
        }
    </style>
</head>

<body class="hold-transition sidebar-mini">
    <div class="wrapper">
        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="/admin/main" class="nav-link">Home</a>
                </li>
            </ul>

            <!-- SEARCH FORM -->
            <form class="form-inline ml-3">
                <div class="input-group input-group-sm">
                    <input class="form-control form-control-navbar" type="search" placeholder="Search"
                        aria-label="Search">
                    <div class="input-group-append">
                        <button class="btn btn-navbar" type="submit">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>
            </form>

            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">

                <!-- Notifications Dropdown Menu -->
                <li class="nav-item dropdown">
                    <a class="nav-link" data-toggle="dropdown" href="#">
                        <i class="far fa-bell"></i>
                        <span class="badge badge-warning navbar-badge">15</span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                        <span class="dropdown-item dropdown-header">15 Notifications</span>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item">
                            <i class="fas fa-envelope mr-2"></i> 4 new messages
                            <span class="float-right text-muted text-sm">3 mins</span>
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item">
                            <i class="fas fa-users mr-2"></i> 8 friend requests
                            <span class="float-right text-muted text-sm">12 hours</span>
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item">
                            <i class="fas fa-file mr-2"></i> 3 new reports
                            <span class="float-right text-muted text-sm">2 days</span>
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
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
                            <div class="float-left">
                                <a href="#" class="btn btn-default btn-flat">Profile</a>
                            </div>
                            <form action="/admin/users/logout" method="POST">
                                <div class="float-right">
                                    <button type="submit" class="btn btn-default btn-flat">Sign out</button>
                                </div>
                                @csrf
                            </form>
                        </li>
                    </ul>
                </li>

            </ul>
        </nav>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        @include('admin.sidebar')

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    @include('admin.alert')
                    <div class="row">
                        <!-- left column -->
                        <div class="col-md-12">
                            <!-- jquery validation -->
                            <div class="card card-primary mt-3">
                                <div class="card-header">
                                    <h3 class="card-title">{{ $title }}</h3>
                                </div>
                                <!-- /.card-header -->
                                <!-- form start -->
                                @yield('content')
                            </div>
                            <!-- /.card -->
                        </div>
                        <!--/.col (left) -->
                        <!-- right column -->
                        <div class="col-md-6">

                        </div>
                        <!--/.col (right) -->
                    </div>
                    <!-- /.row -->
                </div><!-- /.container-fluid -->
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->
        <footer class="main-footer">
            <div class="float-right d-none d-sm-block">
                <b>LouVu Shop</b>
            </div>
            <strong>Since &copy; 2024 by <a href="https://www.facebook.com/trlovu">Trlovu</a>.</strong>
        </footer>

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->

    @include('admin.foot')
</body>

</html>
