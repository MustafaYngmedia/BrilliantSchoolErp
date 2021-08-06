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
              <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
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
                  
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">User</h3>
              </div>
              <form action="{{route($add_url,["id"=>$id])}}" role="form" method="post">
                @csrf
                <div class="card-body row">
                  <div class="form-group col-md-6">
                    <label for="first_name">First Name</label>
                    <input type="first_name" required id="first_name" name="first_name" value="{{old('first_name',@$form_data->first_name)}}" class="form-control" placeholder="Enter First Name">
                  </div>
                  <div class="form-group col-md-6">
                    <label for="last_name">Last Name</label>
                    <input type="last_name" required id="last_name" name="last_name" value="{{old('last_name',@$form_data->last_name)}}" class="form-control" placeholder="Enter Last Name">
                  </div>
                  
                  <div class="form-group col-md-6">
                    <label for="mobile">Mobile</label>
                    <input type="mobile" required id="mobile" name="mobile" value="{{old('mobile',@$form_data->mobile)}}" class="form-control" placeholder="Enter Mobile">
                  </div>
                  
                  <div class="form-group col-md-6">
                    <label for="email">Email</label>
                    <input type="email" required id="email" name="email" value="{{old('email',@$form_data->email)}}" class="form-control" placeholder="Enter Mobile">
                  </div>
                  <div class="form-group col-md-6">
                    @php
                      $user = Auth::user();
                      $readonly = "";

                      if($user->user_role != 1){
                        $readonly = "readonly='readonly'";
                      }
                      $selectrole = @$form_data->user_role;
                      if($user->user_role == 2){
                        $selectrole = 3;
                      }
                    @endphp
                    <label for="user_role">Role</label>
                    <select {{$readonly}} class="form-control" name="user_role" id="user_role">
                        @foreach($all_user_roles as $user_role)
                            <option @if($selectrole == $user_role->id) selected="selected" @endif value="{{$user_role->id}}">{{$user_role->name}}</option>
                        @endforeach
                    </select>
                  </div>
                  <div class="form-group col-md-6">
                    <label for="user_role">Reporting To</label>
                    <select {{$readonly}} class="form-control" name="reporting_to" id="reporting_to">
                      @foreach($all_managers as $manager)
                          <option @if(isset($form_data) && $form_data->reporting_to == $manager->id)) selected="selected" @endif value="{{$manager->id}}">{{$manager->first_name}} {{$manager->last_name}}</option>
                      @endforeach
                    </select>
                  </div>
                  <div class="form-group col-md-6">
                    <label for="password">Password</label>
                    <input type="password" id="password" @if($id == null ) required="required" @endif name="password" class="form-control" placeholder="Enter Password">
                  </div>
                  <div class="form-group col-md-6">
                    <label for="name">Status</label>
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