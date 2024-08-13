@extends('admin.main')
@section('content')
    <table class="table">
        <thead>
            <tr>
                <th style="width: 50px;">ID</th>
                <th>Name</th>
                <th>Sort</th>
                <th>Active</th>
                <th>Update</th>
                <th style="width: 100px">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($sliders as $key => $slider)
                <tr>
                    <th>{{ $slider->id }}</th>
                    <th>{{ $slider->name }}</th>
                    <th>{{ $slider->sort_by }}</th>
                    <th>{!! \App\Helpers\Helper::active($slider->active) !!}</th>
                    <th>{{ $slider->updated_at }}</th>
                    <th>
                        <a href="/admin/sliders/edit/{{ $slider->id }}" style="margin-right: 10px;"><i
                                class="fa-solid fa-pen-to-square"></i></a>
                        <a href="#" onclick="removeRow({{ $slider->id }}, '/admin/sliders/destroy')"><i
                                class="fa-solid fa-trash" style="color: red;"></i></a>
                    </th>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{-- {!! $sliders->links() !!} --}}
@endsection
