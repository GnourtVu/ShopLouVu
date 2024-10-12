@extends('admin.main')
@section('content')
    <table class="table">
        <thead>
            <tr>
                <th style="width: 50px;">ID</th>
                <th>Name</th>
                <th>Phone</th>
                <th>Email</th>
                <th>Point</th>
                <th>Role</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($listCustomer as $key => $customer)
                <tr>
                    <th>{{ $customer->id }}</th>
                    <th>{{ $customer->name }}</th>
                    <th>{{ $customer->phone }}</th>
                    <th>{{ $customer->email }}</th>
                    <th>{{ $customer->point }}</th>
                    <th>
                        @if ($customer->role === 0)
                            <p style="color: rgba(42, 9, 161, 0.909)">Khách hàng vãng lai</p>
                        @else
                            <p style="color: rgb(9, 152, 42)"> Khách hàng đăng nhập</p>
                        @endif
                    </th>
                </tr>
            @endforeach
        </tbody>
    </table>
    <div class="card-footer clearfix">
        {!! $listCustomer->links() !!}
    </div>
@endsection
