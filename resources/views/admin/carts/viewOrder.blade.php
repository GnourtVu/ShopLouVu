@extends('admin.main')
@section('content')
    <div class="customer">
        <ul>
            <li>Customer name : <strong>{{ $customer->name }}</strong></li>
            <li>Address :{{ $customer->address }}</li>
            <li>Phone : {{ $customer->phone }}</li>
            <li>Mail : {{ $customer->email }}</li>
            <li>Note : {{ $customer->content }}</li>
        </ul>
        <table class="table">
            <tbody>
                <tr class="table_head">
                    <th class="column-1">Product</th>
                    <th class="column-2">Name</th>
                    <th class="column-3">Price</th>
                    <th class="column-4">Quantity</th>
                    <th class="column-5">Total</th>
                    <th class="column-6"> </th>
                </tr>
                @php
                    $discount = $order->discount;
                    $total = $order->total;
                @endphp
                @foreach ($carts as $key => $cart)
                    @php
                        $price = $cart->price;
                        $priceEnd = $price * $cart->qty;

                    @endphp
                    <tr>
                        <td class="column-1">
                            <div class="how-itemcart1">
                                <img src="{{ $cart->product->thumb }}" alt="IMG" width="60px" height="60px">
                            </div>
                        </td>
                        <td class="column-2">{{ $cart->product->name }}</td>
                        <td class="column-3"> {{ number_format($cart->price, 0, '', ',') }} đ</td>
                        <td class="column-4">
                            {{ $cart->qty }}
                        </td>
                        <td class="column-5">{{ number_format($priceEnd, 0, '.', ',') }}đ</td>
                    </tr>
                @endforeach
                <tr>
                    <td colspan="4" class="text-right"><strong>Discount :</strong></td>
                    <td style="color: red">-{{ number_format($discount, 0, '.', ',') }}đ</td>
                </tr>
                <tr>
                    <td colspan="4" class="text-right"><strong>Total :</strong></td>
                    <td>{{ number_format($total, 0, '.', ',') }}đ</td>
                </tr>
            </tbody>
        </table>
    </div>
@endsection
