@extends('admin.main')
@section('head')
    <script src="/template/ckeditor/ckeditor.js"></script>
@endsection
@section('content')
    <div class="col-md-6">
        <!-- general form elements -->
        <div class="card card-primary">
            <!-- form start -->
            <form role="form" method="POST">
                <div class="card-body">
                    <div class="form-group">
                        <label for="menu">Category Name</label>
                        <input type="text" class="form-control" value="{{ $menu->name }}" name="name" id="menu"
                            placeholder="Enter name">
                    </div>
                    <div class="form-group">
                        <label for="menu">Category</label>
                        <select class="form-control" name="parent_id">
                            <option value="0" {{ $menu->parent_id === 0 ? 'selected' : '' }}>Category Parent</option>
                            @foreach ($menus as $menuParent)
                                <option value="{{ $menuParent->id }}"
                                    {{ $menu->parent_id === $menuParent->id ? 'selected' : '' }}>{{ $menuParent->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">

                        <label for="menu">Description</label>
                        <textarea name="description"cols="5" rows="2" class="form-control">{{ $menu->description }}</textarea>
                    </div>
                    <div class="form-group">
                        <label for="menu">Description Detail</label>
                        <textarea name="content" id="content" cols="30" rows="10" class="form-control">{{ $menu->content }}</textarea>
                    </div>
                    <div class="form-group">
                        <label for="menu">Active</label>
                        <div class="custom-control custom-radio">
                            <input class="custom-control-input" value="1" type="radio" id="active" name="active"
                                {{ $menu->active === 1 ? 'checked=""' : '' }}>
                            <label for="active" class="custom-control-label">Yes</label>
                        </div>
                        <div class="custom-control custom-radio">
                            <input class="custom-control-input" value="0" type="radio" id="no_active" name="active"
                                {{ $menu->active === 0 ? 'checked=""' : '' }}>
                            <label for="no_active" class="custom-control-label">No</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="menu">Image</label>
                        <input type="file" name="file" class="form-control" id="upload">
                    </div>
                    <div id="image_show">
                        <a href="{{ $menu->thumb }}">
                            <img src="{{ $menu->thumb }}" alt="" width="100px">
                        </a>
                    </div>
                    <input type="hidden" name="thumb" id="thumb" value="{{ $menu->thumb }}">
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
