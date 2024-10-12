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
                        @if (!$customer)
                            <div>
                                hello
                            </div>
                        @else
                            <form action="/user/settings" method="post" enctype="multipart/form-data">
                                <h4 class="mtext-105 cl2 txt-center p-b-30">
                                    <i style="color: rgb(203, 84, 84)">Thông tin khách hàng</i>
                                </h4>
                                <div style="width: 60%;">@include('admin.alert')</div>
                                <div class="wrap-table-shopping-cart">
                                    <div>
                                        <div class="input-group">
                                            <i class="fa-solid fa-envelope"></i>
                                            <input type="text" name="email" placeholder=" Địa chỉ email"
                                                value="{{ $customer->email }}" readonly>
                                        </div>
                                        <div class="input-group">
                                            <i class="fa-solid fa-user"></i>
                                            <input type="text" name="name" value="{{ $customer->name }}">
                                        </div>
                                        <div class="input-group">
                                            <i class="fa-solid fa-phone"></i>
                                            <input type="text" name="phone" placeholder=" Số điện thoại"
                                                value="{{ $customer->phone }}">
                                        </div>

                                        <div id="changePasswordToggleWrapper">
                                            <input type="checkbox" id="changePasswordToggle">
                                            <label for="changePasswordToggle">Đổi mật khẩu ?</label>
                                        </div>

                                        <!-- Các trường nhập mật khẩu sẽ ẩn đi -->
                                        <div id="passwordFields" style="display: none;">
                                            <div class="input-group">
                                                <i class="fa-solid fa-key"></i>
                                                <input type="password" name="password" placeholder=" Nhập mật khẩu cũ">
                                            </div>
                                            <div class="input-group">
                                                <i class="fa-solid fa-key"></i>
                                                <input type="password" name="passwordNew" placeholder=" Nhập mật khẩu mới">
                                            </div>
                                            <div class="input-group">
                                                <i class="fa-solid fa-key"></i>
                                                <input type="password" name="passwordCf"
                                                    placeholder=" Nhập lại mật khẩu mới">
                                            </div>
                                        </div>

                                        @csrf
                                        <div class="btn-wrapper">
                                            <button type="submit" class="btn-submit">
                                                Cập nhật
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        @endif
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

    <!-- JavaScript để điều khiển ẩn/hiện -->
    <script>
        document.getElementById('changePasswordToggle').addEventListener('change', function() {
            var passwordFields = document.getElementById('passwordFields');
            if (this.checked) {
                passwordFields.style.display = 'block'; // Hiển thị khi được chọn
            } else {
                passwordFields.style.display = 'none'; // Ẩn khi bỏ chọn
            }
        });
    </script>
@endsection
