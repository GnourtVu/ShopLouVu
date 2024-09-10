@extends('admin.main')
@section('content')
    <div class="col-md-6">
        <!-- general form elements -->
        <div class="card card-primary">
            <!-- form start -->
            <form role="form" method="POST">
                <div class="card-body">
                    <div class="form-group">
                        <label for="menu">Discount Name</label>
                        <input type="text" class="form-control" value="{{ $discount->name }}" name="name" id="menu"
                            placeholder="Enter name">
                    </div>
                    <div class="form-group">
                        <label for="menu">Discount</label>
                        <input type="text" class="form-control" value="{{ $discount->discount }}" name="discount"
                            placeholder="Enter dicount">
                    </div>
                    <div class="form-group">
                        <label for="menu">Code</label>
                        <input type="text" value="{{ $discount->code }}" class="form-control" name="code"
                            placeholder="Enter code">
                    </div>
                    <div class="form-group">
                        <label for="menu">Active</label>
                        <div class="custom-control custom-radio">
                            <input class="custom-control-input" value="1" type="radio" id="active" name="active"
                                {{ $discount->active === 1 ? 'checked=""' : '' }}>
                            <label for="active" class="custom-control-label">Yes</label>
                        </div>
                        <div class="custom-control custom-radio">
                            <input class="custom-control-input" value="0" type="radio" id="no_active" name="active"
                                {{ $discount->active === 0 ? 'checked=""' : '' }}>
                            <label for="no_active" class="custom-control-label">No</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="menu">Image Main</label>
                        <input type="file" name="thumb" class="form-control" id="upload">
                    </div>
                    <div id="image_show">
                        <a href="{{ $discount->thumb }}">
                            <img src="{{ $discount->thumb }}" alt="" width="100px">
                        </a>
                    </div>
                    <input type="hidden" name="thumb" id="thumb" value="{{ $discount->thumb }}">
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
