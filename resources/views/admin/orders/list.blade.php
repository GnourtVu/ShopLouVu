@extends('admin.main')
@section('content')
    <table class="table">
        <thead>
            <tr>
                <th style="width: 50px;">ID</th>
                <th>Payment</th>
                <th>Status</th>
                <th>Created at</th>
                <th>Total</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($orders as $key => $order)
                <tr>
                    <th>{{ $order->id }}</th>
                    <th>{{ $order->payment_method }}</th>
                    <th>
                        <p
                            class="badge 
                          @if ($order->order_status == 'Chờ xác nhận') badge-warning
                          @elseif ($order->order_status == 'Đang giao') badge-primary
                          @elseif ($order->order_status == 'Đã giao') badge-success
                           @elseif ($order->order_status == 'Đã huỷ') badge-danger
                          @else badge-secondary @endif">
                            {{ $order->order_status }}
                        </p>
                    </th>
                    <th>{{ $order->created_at->format('d/m/Y H:i:s') }}</th>
                    <th>{{ number_format($order->total, '0', '.', ',') }}đ</th>
                    <th>
                        <a class="btn btn-primary" href="/admin/order/view/{{ $order->id }}" style="margin-right: 10px;"><i
                                class="fas fa-eye"></i></a>
                        <a href="#" onclick="removeRow({{ $order->id }}, '/admin/destroy')"><i
                                class="fa-solid fa-trash" style="color: red;"></i></a>
                    </th>
                </tr>
            @endforeach
        </tbody>
    </table>
    <div class="card-footer clearfix">
        {!! $orders->links() !!}
    </div>
@endsection
