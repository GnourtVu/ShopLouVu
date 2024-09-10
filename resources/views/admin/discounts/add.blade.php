@extends('admin.main')
@section('content')
    <div class="col-md-6">
        <!-- general form elements -->
        <div class="card card-primary">

            <!-- form start -->
            <form role="form" action="" method="POST">
                <div class="card-body">
                    <div class="form-group">
                        <label for="menu">Discount Name</label>
                        <input type="text" class="form-control" name="name" placeholder="Enter name">
                    </div>
                    <div class="form-group">
                        <label for="menu">Discount</label>
                        <input type="text" class="form-control" name="discount" placeholder="Enter dicount">
                    </div>
                    <div class="form-group">
                        <label for="menu">Code</label>
                        <input type="text" class="form-control" name="code" placeholder="Enter code">
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
                        <label for="menu">Image</label>
                        <input type="file" name="thumb" class="form-control" id="upload">
                    </div>
                    <div id="image_show">

                    </div>
                    {{-- <input type="hidden" name="thumb" id="thumb"> --}}
                    @csrf
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Create</button>
                    </div>
            </form>
        </div>
        <!-- /.card -->
    </div>
@endsection
