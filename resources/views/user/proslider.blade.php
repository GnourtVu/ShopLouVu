@extends('user.main')
@section('content')
    <!-- Product -->
    <form action="/searchProductUser">
        <section class="bg0 p-t-23 p-b-140 p-t-90">
            <div class="container">
                <div style="width: 60%;">@include('admin.alert')</div>
                <div>
                    <div class="hov-img0">
                        <a href="#"><img src="/template/user/images/thudong.jpg" alt="IMG"></a>
                    </div>
                </div>
                <div class="flex-w flex-sb-m p-b-30">
                    <div class="flex-w flex-l-m filter-tope-group m-tb-10">
                        <a href="/user/shop" class="stext-106 cl6 hov1 bor3 trans-04 m-r-32 m-tb-5 how-active1"
                            data-filter="*" data-link="shop">
                            Tất cả sản phẩm
                        </a>
                    </div>
                    <!-- Filter -->
                </div>
                @include('user.product')
                <div class="card-footer clearfix" t>
                    {!! $productss->links() !!}
                </div>
            </div>
        </section>
    </form>
@endsection
