@extends('user.main')
@section('content')
    <div class="p-t-90">
        <!-- Title page -->
        <section class="bg-img1 txt-center p-lr-15 p-tb-92" style="background-image: url('/template/user/images/gr2.jpg');">
            <h2 class="ltext-105 cl0 txt-center">

            </h2>
        </section>
        <!-- Content page -->
        <section class="bg0 p-t-104 p-b-116">
            <div class="container">
                <div class="flex-w flex-tr">
                    <div class="size-210 bor10 p-lr-70 p-t-55 p-b-70 p-lr-15-lg w-full-md">
                        <form action="/user/register" method="post" enctype="multipart/form-data">
                            <h4 class="mtext-105 cl2 txt-center p-b-30">
                                <i style="color: rgb(203, 84, 84)">Đăng ký người dùng để có được nhiều ưu đãi nhất nào!</i>
                            </h4>
                            <div style="width: 60%;">@include('admin.alert')</div>
                            <div class="wrap-table-shopping-cart">
                                <div>
                                    <div class="input-group">
                                        <i class="fa-solid fa-user"></i>
                                        <input type="text" name="name" placeholder=" Họ tên"
                                            value="{{ old('name') }}">
                                    </div>
                                    <div class="input-group">
                                        <i class="fa-solid fa-phone"></i>
                                        <input type="text" name="phone" placeholder=" Số điện thoại"
                                            value="{{ old('phone') }}">
                                    </div>
                                    <div class="input-group">
                                        <i class="fa-solid fa-envelope"></i>
                                        <input type="text" name="email" placeholder=" Địa chỉ email"
                                            value="{{ old('email') }}">
                                    </div>
                                    <div class="input-group">
                                        <i class="fa-solid fa-key"></i>
                                        <input type="password" name="password" placeholder=" Nhập mật khẩu"
                                            value="{{ old('password') }}">
                                    </div>
                                    <div class="input-group">
                                        <i class="fa-solid fa-key"></i>
                                        <input type="password" name="passwordCf" placeholder=" Nhập lại mật khẩu"
                                            value="{{ old('passwordCf') }}">
                                    </div>
                                    @csrf
                                    <div class="btn-wrapper">
                                        <button type="submit" class="btn-submit">
                                            Đăng ký
                                        </button>
                                    </div>
                                    <div class="register-link">
                                        Bạn đã có tài khoản? <a href="/user/login">Đăng nhập</a>
                                    </div>
                                </div>
                            </div>

                        </form>
                    </div>

                    <div class="size-210 bor10 flex-w flex-col-m p-lr-93 p-tb-30 p-lr-15-lg w-full-md">

                        <div class="how-bor2">
                            <div class="hov-img0">
                                <img src="/template/user/images/lg2.webp" alt="IMG">
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </section>
    </div>
@endsection
