@extends('admin.main')

@section('styles')
    <style>
        .pagination .page-link svg {
            width: 20px;
            /* Thay đổi kích thước của icon */
            height: 20px;
            /* Thay đổi kích thước của icon */
        }
    </style>
@endsection
@section('content')
    <form class="form-inline ml-3" action="/searchProduct">
        <p>Tìm kiếm sản phẩm :</p>
        <div class="input-group input-group-sm">
            <input class="form-control form-control-navbar" name="search" type="search" placeholder="Search"
                aria-label="Search">
            <div class="input-group-append">
                <button class="btn btn-navbar" type="submit">
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </div>
    </form>
    <table class="table">
        <thead>
            <tr>
                <th style="width: 50px;">ID</th>
                <th>Name</th>
                <th>Category</th>
                <th>Price</th>
                <th>Price sale</th>
                <th>Active</th>
                <th>Quantity</th>
                <th>Update</th>
                <th style="width: 100px">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($products as $key => $product)
                <tr>
                    <th>{{ $product->id }}</th>
                    <th>{{ $product->name }}</th>
                    <th>{{ $product->menu->name }}</th>
                    <th>{{ $product->price }}</th>
                    <th>{{ $product->price_sale }}</th>
                    <th>{!! \App\Helpers\Helper::active($product->active) !!}</th>
                    <th>{{ $product->qty_stock }}</th>
                    <th>{{ $product->updated_at }}</th>
                    <th>
                        <a href="/admin/products/edit/{{ $product->id }}" style="margin-right: 10px;"><i
                                class="fa-solid fa-pen-to-square"></i></a>
                        <a href="#" onclick="removeRow({{ $product->id }}, '/admin/products/destroy')"><i
                                class="fa-solid fa-trash" style="color: red;"></i></a>
                    </th>
                </tr>
            @endforeach
        </tbody>
    </table>
    <div class="card-footer clearfix">
        {!! $products->links() !!}
    </div>
@endsection
