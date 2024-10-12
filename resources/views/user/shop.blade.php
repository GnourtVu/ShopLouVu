@extends('user.main')
@section('content')
    <!-- Product -->
    <form action="/searchProductUser">
        <section class="bg0 p-t-23 p-b-140 p-t-90">
            <div class="container">
                <div style="width: 60%;">@include('admin.alert')</div>
                <div>
                    <div class="hov-img0">
                        <a href="#"><img src="/template/user/images/sale.webp" alt="IMG"></a>
                    </div>
                </div>
                <div class="flex-w flex-sb-m p-b-30">

                    <div class="flex-w flex-l-m filter-tope-group m-tb-10">
                        <a href="/user/shop" class="stext-106 cl6 hov1 bor3 trans-04 m-r-32 m-tb-5 how-active1"
                            data-filter="*" data-link="shop">
                            Tất cả sản phẩm
                        </a>
                        {{-- @foreach ($menus as $menu)
                        <a href="/categories/{{ $menu->id }}-{{ $menu->name }}.html"
                            class="stext-106 cl6 hov1 bor3 trans-04 m-r-32 m-tb-5" data-filter=".women"
                            data-link="category-{{ $menu->id }}">
                            {{ $menu->name }}
                        </a>
                    @endforeach --}}
                    </div>
                    <div class="flex-w flex-c-m m-tb-10">
                        <div
                            class="flex-c-m stext-106 cl6 size-104 bor4 pointer hov-btn3 trans-04 m-r-8 m-tb-4 js-show-filter">
                            <i class="icon-filter cl2 m-r-6 fs-15 trans-04 zmdi zmdi-filter-list"></i>
                            <i class="icon-close-filter cl2 m-r-6 fs-15 trans-04 zmdi zmdi-close dis-none"></i>
                            Bộ lọc
                        </div>

                        <div class="flex-c-m stext-106 cl6 size-105 bor4 pointer hov-btn3 trans-04 m-tb-4 js-show-search">
                            <i class="icon-search cl2 m-r-6 fs-15 trans-04 zmdi zmdi-search"></i>
                            <i class="icon-close-search cl2 m-r-6 fs-15 trans-04 zmdi zmdi-close dis-none"></i>
                            Tìm kiếm
                        </div>
                    </div>

                    <!-- Search product -->
                    <div class="dis-none panel-search w-full p-t-10 p-b-15">
                        <div class="bor8 dis-flex p-l-15">
                            <button class="size-113 flex-c-m fs-16 cl2 hov-cl1 trans-04">
                                <i class="zmdi zmdi-search"></i>
                            </button>

                            <input class="mtext-107 cl2 size-114 plh2 p-r-15" type="text" name="search"
                                placeholder="Search">
                        </div>
                    </div>

                    <!-- Filter -->
                    <div class="dis-none panel-filter w-full p-t-10">
                        <div class="wrap-filter flex-w bg6 w-full p-lr-40 p-t-27 p-lr-15-sm">
                            <div class="filter-col1 p-r-15 p-b-27">
                                <div class="mtext-102 cl2 p-b-15">
                                    Sắp xếp theo
                                </div>

                                <ul>
                                    <li class="p-b-6">
                                        <a href="{{ url()->current() }}?sort=default"
                                            class="filter-link stext-106 trans-04">
                                            Mặc định
                                        </a>
                                    </li>
                                    <li class="p-b-6">
                                        <a href="{{ url()->current() }}?listProduct=hot"
                                            class="filter-link stext-106 trans-04">
                                            Nổi bật
                                        </a>
                                    </li>
                                    <li class="p-b-6">
                                        <a href="{{ url()->current() }}?listProduct=new"
                                            class="filter-link stext-106 trans-04">
                                            Mới nhất
                                        </a>
                                    </li>
                                    <li class="p-b-6">
                                        <a href="{{ request()->fullUrlWithQuery(['price' => 'asc']) }}"
                                            class="filter-link stext-106 trans-04">
                                            Giá : Thấp lên cao
                                        </a>
                                    </li>
                                    <li class="p-b-6">
                                        <a href="{{ request()->fullUrlWithQuery(['price' => 'desc']) }}"
                                            class="filter-link stext-106 trans-04">
                                            Giá : Cao xuống thấp
                                        </a>
                                    </li>
                                </ul>
                            </div>

                            <div class="filter-col2 p-r-15 p-b-27">
                                <div class="mtext-102 cl2 p-b-15">
                                    Khoảng giá
                                </div>

                                <ul>
                                    <li class="p-b-6">
                                        <a href="{{ request()->url() }}"
                                            class="filter-link stext-106 trans-04 filter-link-active">
                                            Tất cả
                                        </a>
                                    </li>

                                    <li class="p-b-6">
                                        <a href="{{ request()->fullUrlWithQuery(['price_range' => 'low_price']) }}"
                                            class="filter-link stext-106 trans-04">
                                            Từ <u>đ</u>100.000 - <u>đ</u>200.000
                                        </a>
                                    </li>
                                    <li class="p-b-6">
                                        <a href="{{ request()->fullUrlWithQuery(['price_range' => 'medium_price']) }}"
                                            class="filter-link stext-106 trans-04">
                                            Từ <u>đ</u>200.000 - <u>đ</u>300.000
                                        </a>
                                    </li>
                                    <li class="p-b-6">
                                        <a href="{{ request()->fullUrlWithQuery(['price_range' => 'high_price']) }}"
                                            class="filter-link stext-106 trans-04">
                                            Trên <u>đ</u>300.000
                                        </a>
                                    </li>
                                </ul>
                            </div>


                            <div class="filter-col4 p-b-27">
                                <div class="mtext-102 cl2 p-b-15">
                                    Giới tính
                                </div>

                                <div class="flex-w p-t-4 m-r--5">
                                    @foreach ($menus as $menu)
                                        <a href="/categories/{{ $menu->id }}-{{ $menu->slug }}.html"
                                            class="flex-c-m stext-107 cl6 size-301 bor7 p-lr-15 hov-tag1 trans-04 m-r-5 m-b-5">
                                            {{ $menu->name }}
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @include('user.product')
                <div class="card-footer clearfix" t>
                    {!! $productss->links() !!}
                </div>
            </div>
        </section>
    </form>
@endsection
