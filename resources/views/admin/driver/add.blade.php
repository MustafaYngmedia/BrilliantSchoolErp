@extends('admin.layout.app')
@section('header')
<section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>{{$heading}}</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{route('admin.home')}}">Home</a></li>
              <li class="breadcrumb-item active">{{$type}}</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
@endsection
@section('content')
<section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
            <!-- general form elements -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">{{$heading}}</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form action="{{route($add_url,["id"=>$id])}}" role="form" method="post">
                @csrf
                @if(count($errors) > 0 )
          <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <ul class="p-0 m-0" style="list-style: none;">
                @foreach($errors->all() as $error)
                <li>{{$error}}</li>
                @endforeach
            </ul>
        </div>
        @endif
                <div class="card-body row">
                  <div class="form-group col-md-6">
                    <label for="name">Name</label>
                    <input type="name" required id="name" name="name" value="{{old('name',@$form_data->name)}}" class="form-control" placeholder="Enter Driver Name">
                  </div>
                  
                  
                  <div class="form-group col-md-6">
                    <label for="license_number">License number</label>
                    <input type="text" id="license_number" name="license_number" value="{{old('license_number',@$form_data->license_number)}}" class="form-control" placeholder="Enter License Number">
                  </div>
                  
                  <div class="form-group col-md-6">
                    <label for="mobile">Mobile</label>
                    <input type="text" required id="mobile" name="mobile" value="{{old('mobile',@$form_data->mobile)}}" class="form-control" placeholder="Enter Mobile">
                  </div>
                  <div class="form-group col-md-6">
                    <label for="status">Status</label>
                    <select class="form-control" required name="status" id="status">
                      <option value="1" @if(isset($form_data) && $form_data->status == 1)) selected="selected" @endif >Active</option>
                      <option value="0" @if(isset($form_data) && $form_data->status == 0)) selected="selected" @endif >InActive</option>
                    </select>
                  </div>
                </div>
                <div class="card-footer">
                  <button type="submit" class="btn btn-primary">Submit</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </section>
@endsection