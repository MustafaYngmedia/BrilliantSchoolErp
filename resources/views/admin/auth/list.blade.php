@extends('admin.layout.app')
@section('content')
<div class="container">
        <div class="row">
          <div class="col-md-12">
            <!-- datatables -->
            @if(session()->has('message'))
                <div class="alert alert-success">
                    {{ session()->get('message') }}
                </div>
            @endif
            <div class="card my-3 border-top-thick">
              <div class="card-header">
                  <h3 class="card-title">User List</h3>
                
                  <div class="card-tools">
                    <a href="{{route('user.register.add')}}" class="btn btn-success float-left">
                      Add User
                    </a>
                  </div>
              </div>

                <div class="card-body">
                <div class="row">
                  <div class="col-md-3">
                    <label>Name</label>
                    <input type="text" class="form-control" placeholder="Search By Name" name="name" id="name"/>
                  </div>
                  <div class="col-md-3">
                    <label>Mobile</label>
                    <input type="text" class="form-control" placeholder="Search By Mobile" name="mobile" id="mobile"/>
                  </div>
                @if(Auth::guard()->user()->user_role == 1)
                  <div class="col-md-3">
                    <label>Role Type</label>
                    <select class="form-control" name="user_role" id="user_role">
                      <option value="">Select Role</option>
                      @foreach($all_user_roles as $user_role)
                          <option @if(isset($form_data) && $form_data->user_role == $user_role->id)) selected="selected" @endif value="{{$user_role->id}}">{{$user_role->name}}</option>
                      @endforeach
                    </select>
                  </div>
                @endif
                  
                  <div class="col-md-3">
                    <label>Status</label>
                    <select class="form-control" required="" name="status" id="status">
                      <option value="">Select Status</option>
                      <option value="1">Active</option>
                      <option value="0">InActive</option>
                    </select>
                  </div>
                </div>
                <br />
                <div class="row">
                  <div class="form-group col-md-3">
                    <label>
                      <button class="btn find btn-primary">Find</button>
                      <button class="btn reset btn-warning">Reset</button>
                    </label>
                  </div>
                </div>
                <div class="table-responsive">
                  <table
                    class="datable table table-striped makeDatatable"
                    style="width: 100%"
                  >
                    <thead>
                      <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Mobile</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Status</th>
                        <th>Edit</th>
                      </tr>
                    </thead>
                    <tbody>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
            <!-- data tables -->
          </div>
        </div>
      </div>
@endsection
@section('footer')

<script>
  $('.find').click(function(){
     $('.datable').DataTable().draw(true);
    });
  $('.reset').click(function(){
      $("#name").val('');
      $("#mobile").val('');
      $("#user_role").val('');
      $("#status").val('');
     $('.datable').DataTable().draw(true);
  });

  $(function () {
    $(".datable").DataTable({
        "responsive": true,
        "processing": true,
        "serverSide": true,
        "searching": false,
        "order": [[ 1, "desc" ]],
        "ajax": {
          url: "{{route('user.list',['ajax'=>'true'])}}",
          type: 'GET',
          data: function (d) {
            d.mobile = $('#mobile').val();
            d.user_role = $('#user_role').val();
            d.name = $('#name').val();
            d.status = $('#status').val()
          }
        },
        "columns": [
            {data: 'id', name: 'id'},
            {data: 'name', name: 'name'},
            {data: 'mobile', name: 'mobile'},
            {data: 'email', name: 'email'},
            {data: 'role', name: 'role'},
            {data: 'status_raw', name: 'status_raw'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ]
    });
    
  });
</script>
@endsection