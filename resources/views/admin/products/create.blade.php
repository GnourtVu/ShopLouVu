@extends('admin.main')
@section('head')
    <script src="/template/ckeditor/ckeditor.js"></script>
@endsection
@section('content')
    <div class="col-md-10">
        <!-- general form elements -->
        <div class="card card-primary">

            <!-- form start -->
            <form role="form" action="" method="POST" enctype="multipart/form-data">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <label for="menu">Product Name</label>
                            <input type="text" class="form-control" name="name" id="menu"
                                value="{{ old('name') }}" placeholder="Enter name">
                        </div>
                        <div class="col-md-6">
                            <label for="menu">Category</label>
                            <select class="form-control" name="menu_id">

                                @foreach ($menus as $menu)
                                    <option value="{{ $menu->id }}">{{ $menu->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label for="menu">Price</label>
                            <input type="text" class="form-control" name="price" value="{{ old('price') }}">
                        </div>
                        <div class="col-md-6">
                            <label for="menu">Price Sale</label>
                            <input type="text" class="form-control" name="price_sale" value="{{ old('price_sale') }}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="menu">Description</label>
                        <textarea name="description"cols="5" rows="2" class="form-control">{{ old('description') }}</textarea>
                    </div>
                    <div class="form-group">
                        <label for="menu">Description Detail</label>
                        <textarea name="content" id="content" cols="30" rows="10" class="form-control">{{ old('content') }}</textarea>
                    </div>
                    <div class="form-group">
                        <label for="menu">Active</label>
                        <div class="custom-control custom-radio">
                            <input class="custom-control-input" value="1" type="radio" id="active" name="active"
                                checked="">
                            <label for="active" class="custom-control-label">Yes</label>
                        </div>
                        <div class="custom-control custom-radio">
                            <input class="custom-control-input" value="0" type="radio" id="no_active" name="active">
                            <label for="no_active" class="custom-control-label">No</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="menu">Image Main</label>
                        <input type="file" name="file" class="form-control" id="upload">
                    </div>
                    <div id="image_show">
                    </div>
                    <input type="hidden" name="thumb" id="thumb">
                    <div class="form-group">
                        <label for="menu">Image 1</label>
                        <input type="file" name="image1" class="form-control" id="upload">
                    </div>
                    <input type="hidden" name="image1" id="image1">
                    <div class="form-group">
                        <label for="menu">Image 2</label>
                        <input type="file" name="image2" class="form-control" id="upload">
                    </div>
                    <input type="hidden" name="image2" id="image2">
                    <div class="form-group">
                        <label for="menu">Image 3</label>
                        <input type="file" name="image3" class="form-control" id="upload">
                    </div>
                    <input type="hidden" name="image3" id="image3">
                    <!-- /.card-body -->
                    @csrf
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Create</button>
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
