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
                                value="{{ $product->name }}" placeholder="Enter name">
                        </div>
                        <div class="col-md-6">
                            <label for="menu">Category</label>
                            <select class="form-control" name="menu_id">
                                @foreach ($menus as $menu)
                                    <option value="{{ $menu->id }}"
                                        {{ $product->menu_id === $menu->id ? 'selected' : '' }}>{{ $menu->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label for="menu">Price</label>
                            <input type="text" class="form-control" name="price" value="{{ $product->price }}">
                        </div>
                        <div class="col-md-6">
                            <label for="menu">Price Sale</label>
                            <input type="text" class="form-control" name="price_sale" value="{{ $product->price_sale }}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="menu">Description</label>
                        <textarea name="description"cols="5" rows="2" class="form-control">{{ $product->description }}</textarea>
                    </div>
                    <div class="form-group">
                        <label for="menu">Description Detail</label>
                        <textarea name="content" id="content" cols="30" rows="10" class="form-control">{{ $product->content }}</textarea>
                    </div>
                    <div class="form-group">
                        <label for="menu">Active</label>
                        <div class="custom-control custom-radio">
                            <input class="custom-control-input" value="1" type="radio" id="active" name="active"
                                {{ $product->active === 1 ? 'checked=""' : '' }}>
                            <label for="active" class="custom-control-label">Yes</label>
                        </div>
                        <div class="custom-control custom-radio">
                            <input class="custom-control-input" value="0" type="radio" id="no_active" name="active"
                                {{ $product->active === 0 ? 'checked=""' : '' }}>
                            <label for="no_active" class="custom-control-label">No</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label for="menu">Quantity stock</label>
                        <label class="form-control">{{ $product->qty_stock }}</label>
                    </div>
                    <div class="form-group">
                        <label for="sizes_colors">Sizes and Colors</label>
                        <div class="row">
                            @foreach ($sizes as $size)
                                @foreach ($colors as $color)
                                    <div class="col-md-4">
                                        <label>{{ $size->name }} - {{ $color->name }}</label>
                                        <input type="number" class="form-control"
                                            name="qty[{{ $size->id }}][{{ $color->id }}]"
                                            value="{{ isset($quantities[$size->id][$color->id]) ? $quantities[$size->id][$color->id] : 0 }}"
                                            placeholder="Enter quantity">
                                    </div>
                                @endforeach
                            @endforeach
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <label for="menu">Image Main</label>
                            <input type="file" name="thumb" class="form-control" id="upload">
                            <div id="image_show">
                                <a href="{{ $product->thumb }}">
                                    <img src="{{ $product->thumb }}" alt="" width="70px">
                                </a>
                            </div>
                            <input type="hidden" name="thumb" id="thumb" value="{{ $product->thumb }}">
                        </div>
                        <div class="col-md-3">
                            <label for="menu">Image 1</label>
                            <input type="file" name="image1" class="form-control" id="upload">
                            <div id="image_show">
                                <a href="{{ $product->image1 }}">
                                    <img src="{{ $product->image1 }}" alt="" width="70px">
                                </a>
                            </div>
                            <input type="hidden" name="image1" id="image1" value="{{ $product->image1 }}">
                        </div>
                        <div class="col-md-3">
                            <label for="menu">Image 2</label>
                            <input type="file" name="image2" class="form-control" id="upload">
                            <div id="image_show">
                                <a href="{{ $product->image2 }}">
                                    <img src="{{ $product->image2 }}" alt="" width="70px">
                                </a>
                            </div>
                            <input type="hidden" name="image2" id="image2" value="{{ $product->image2 }}">
                        </div>
                        <div class="col-md-3">
                            <label for="menu">Image 3</label>
                            <input type="file" name="image3" class="form-control" id="upload">
                            <div id="image_show">
                                <a href="{{ $product->image3 }}">
                                    <img src="{{ $product->image3 }}" alt="" width="70px">
                                </a>
                            </div>
                            <input type="hidden" name="image3" id="image3" value="{{ $product->image3 }}">
                        </div>
                    </div>
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
