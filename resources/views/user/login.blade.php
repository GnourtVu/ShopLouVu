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
                        <form action="/user/login" method="post" enctype="multipart/form-data">
                            <h4 class="mtext-105 cl2 txt-center p-b-30">
                                Chào mừng bạn đến với LouVu
                            </h4>
                            <div style="width: 
                            50%; ">
                                @include('admin.alert')
                            </div>
                            <div class="wrap-table-user-login">
                                <div class="form-group">
                                    <label for="email" class="form-controll">Nhập email: </label>
                                    <input type="email" id="email" name="email" placeholder="Nhập email"
                                        class="input-field">
                                </div>
                                <div class="form-group">
                                    <label for="password" class="form-controll">Nhập mật khẩu: </label>
                                    <input type="password" id="password" name="password" placeholder="********"
                                        class="input-field">
                                </div>
                                @csrf
                                <div class="btn-wrapper">
                                    <button type="submit" class="btn-submit">
                                        Đăng nhập
                                    </button>
                                </div>
                                <!-- Thêm dòng chưa có tài khoản -->
                                <div class="register-link">
                                    Bạn chưa có tài khoản? <a href="/user/register">Đăng ký</a>
                                </div>
                            </div>
                        </form>
                    </div>

                    <div class="size-210 bor10 flex-w flex-col-m p-lr-93 p-tb-30 p-lr-15-lg w-full-md">

                        <div class="how-bor2">
                            <div class="hov-img0">
                                <img src="/template/user/images/lg1.webp" alt="IMG">
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </section>
    </div>
@endsection
