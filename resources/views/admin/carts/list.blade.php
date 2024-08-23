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
    {{-- @include('admin.alert') --}}
    <table class="table">
        <thead>
            <tr>
                <th style="width: 50px;">Order_id</th>
                <th>Customer name</th>
                <th>Order date</th>
                <th style="width: 100px">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($customers as $customer)
                <tr>
                    <th>{{ $customer->id }}</th>
                    <th>{{ $customer->name }}</th>
                    <th>{{ $customer->created_at }}</th>
                    <th>
                        <a class="btn btn-primary" href="/admin/customer/view/{{ $customer->id }}"
                            style="margin-right: 10px;"><i class="fas fa-eye"></i></a>
                        <a href="#" onclick="removeRow({{ $customer->id }}, '/admin/destroy')"><i
                                class="fa-solid fa-trash" style="color: red;"></i></a>
                    </th>
                </tr>
            @endforeach
        </tbody>
    </table>
    <div class="card-footer clearfix">
        {!! $customers->links() !!}
    </div>
@endsection
