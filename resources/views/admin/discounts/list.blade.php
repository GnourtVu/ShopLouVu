@extends('admin.main')
@section('content')
    <table class="table">
        <thead>
            <tr>
                <th style="width: 50px;">ID</th>
                <th>Name</th>
                <th>Discount</th>
                <th>Code</th>
                <th>Active</th>
                <th style="width: 100px">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($discounts as $key => $discount)
                <tr>
                    <th>{{ $discount->id }}</th>
                    <th>{{ $discount->name }}</th>
                    <th>{{ number_format($discount->discount, '0', '.', ',') }}đ</th>
                    <th>{{ $discount->code }}</th>
                    <th>{!! \App\Helpers\Helper::active($discount->active) !!}</th>
                    <th>
                        <a href="/admin/discounts/edit/{{ $discount->id }}" style="margin-right: 10px;"><i
                                class="fa-solid fa-pen-to-square"></i></a>
                        <a href="#" onclick="removeRow({{ $discount->id }}, '/admin/discounts/destroy')"><i
                                class="fa-solid fa-trash" style="color: red;"></i></a>
                    </th>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{-- {!! $sliders->links() !!} --}}
@endsection
