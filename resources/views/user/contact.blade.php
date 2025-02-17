@extends('user.main')
@section('content')
    <div class="p-t-90">
        <!-- Title page -->
        <section class="bg-img1 txt-center p-lr-15 p-tb-92" style="background-image: url('/template/user/images/bg-01.jpg');">
            <h2 class="ltext-105 cl0 txt-center">
                Liên hệ
            </h2>
        </section>
        <!-- Content page -->
        <section class="bg0 p-t-104 p-b-116">
            <div class="container">
                <div class="flex-w flex-tr">
                    <div class="size-210 bor10 p-lr-70 p-t-55 p-b-70 p-lr-15-lg w-full-md">
                        <form action="/user/contact" method="post" enctype="multipart/form-data">
                            <h4 class="mtext-105 cl2 txt-center p-b-30">
                                Gửi cho chúng tôi lời nhắn
                            </h4>
                            @include('admin.alert')
                            <div class="bor8 m-b-20 how-pos4-parent">
                                <input class="stext-111 cl2 plh3 size-116 p-l-62 p-r-30" type="email" name="email"
                                    placeholder="Địa chỉ email của bạn">
                                <img class="how-pos4 pointer-none" src="/template/user/images/icons/icon-email.png"
                                    alt="ICON">
                            </div>

                            <div class="bor8 m-b-30">
                                <textarea class="stext-111 cl2 plh3 size-120 p-lr-28 p-tb-25" name="content" placeholder="Gửi lời nhắn cho chúng tôi."></textarea>
                            </div>
                            @csrf
                            <button type="submit"
                                class="flex-c-m stext-101 cl0 size-121 bg3 bor1 hov-btn3 p-lr-15 trans-04 pointer">
                                Gửi
                            </button>
                        </form>
                    </div>

                    <div class="size-210 bor10 flex-w flex-col-m p-lr-93 p-tb-30 p-lr-15-lg w-full-md">
                        <div class="flex-w w-full p-b-42">
                            <span class="fs-18 cl5 txt-center size-211">
                                <span class="lnr lnr-map-marker"></span>
                            </span>

                            <div class="size-212 p-t-2">
                                <span class="mtext-110 cl2">
                                    Địa chỉ
                                </span>

                                <p class="stext-115 cl6 size-213 p-t-18">
                                    LouVu Store Center 2th floor, 88 Tay Lai Xa, Kim Chung,Hoai Duc,Ha Noi
                                </p>
                            </div>
                        </div>

                        <div class="flex-w w-full p-b-42">
                            <span class="fs-18 cl5 txt-center size-211">
                                <span class="lnr lnr-phone-handset"></span>
                            </span>

                            <div class="size-212 p-t-2">
                                <span class="mtext-110 cl2">
                                    Hãy gọi cho chúng tôi
                                </span>

                                <p class="stext-115 cl1 size-213 p-t-18">
                                    0866805261
                                </p>
                            </div>
                        </div>

                        <div class="flex-w w-full">
                            <span class="fs-18 cl5 txt-center size-211">
                                <span class="lnr lnr-envelope"></span>
                            </span>

                            <div class="size-212 p-t-2">
                                <span class="mtext-110 cl2">
                                    Hỗ trợ
                                </span>

                                <p class="stext-115 cl1 size-213 p-t-18">
                                    trlovu24@gmail.com
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
