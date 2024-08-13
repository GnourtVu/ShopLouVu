@extends('admin.main')
@section('head')
    <script src="/template/ckeditor/ckeditor.js"></script>
@endsection
@section('content')
    <div class="col-md-6">
        <!-- general form elements -->
        <div class="card card-primary">

            <!-- form start -->
            <form role="form" action="" method="POST">
                <div class="card-body">
                    <div class="form-group">
                        <label for="menu">Slider Name</label>
                        <input type="text" class="form-control" name="name" value="{{ $slider->name }}">
                    </div>
                    <div class="form-group">
                        <label for="menu">Url</label>
                        <input type="text" class="form-control" name="url" value="{{ $slider->url }}">
                    </div>
                    <div class="form-group">
                        <label for="menu">Sort</label>
                        <input type="number" name="sort_by" value="{{ $slider->sort_by }}" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="menu">Active</label>
                        <div class="custom-control custom-radio">
                            <input class="custom-control-input" value="1" type="radio" id="active" name="active"
                                {{ $slider->active === 1 ? 'checked=""' : '' }}>
                            <label for="active" class="custom-control-label">Yes</label>
                        </div>
                        <div class="custom-control custom-radio">
                            <input class="custom-control-input" value="0" type="radio" id="no_active" name="active"
                                {{ $slider->active === 0 ? 'checked=""' : '' }}>
                            <label for="no_active" class="custom-control-label">No</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="menu">Image</label>
                        <input type="file" name="file" class="form-control" id="upload">
                    </div>
                    <div id="image_show">
                        <a href="{{ $slider->thumb }}">
                            <img src="{{ $slider->thumb }}" alt="" width="100px">
                        </a>
                    </div>
                    <input type="hidden" name="thumb" id="thumb" value="{{ $slider->thumb }}">
                    <!-- /.card-body -->
                    @csrf
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
            </form>
        </div>
        <!-- /.card -->
    </div>
@endsection
@section('footer')
    <script>
        CKEDITOR.replace('content', {
            removePlugins: 'exportpdf'
        });
    </script>
@endsection
