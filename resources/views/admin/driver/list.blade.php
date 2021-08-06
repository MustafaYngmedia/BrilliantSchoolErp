@extends('admin.layout.app')
@section('content')
<div class="container">
        <div class="row">
          <div class="col-md-12 col-lg-12">
            <!-- datatables -->
            @if(session()->has('message'))
                <div class="alert alert-success">
                    {{ session()->get('message') }}
                </div>
              @endif
            <div class="card my-3 border-top-thick">
              <div class="card-header">
                  <h3 class="card-title">{{$main_heading}}</h3>
                
                  <div class="card-tools">
                    <a href="{{route($add_url)}}" class="btn btn-success float-left">
                      {{$add_button}}
                    </a>
                  </div>
              </div>

              

                <div class="card-body">
                <div class="row">
                  <div class="col-md-3">
                    <label>Name</label>
                    <input type="text" class="form-control" placeholder="Search By Customer Name" name="name" id="name"/>
                  </div>
                  <div class="col-md-3">
                    <label>Mobile</label>
                    <input type="text" class="form-control" placeholder="Search By Mobile" name="mobile" id="mobile" />
                  </div>
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
                <br />
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
  $(".delete-button").click(function(e){
      if(confirm("Are you sure you want to delete this ?")){
        window.location.href = $(".delete-button").attr("data-href");
      }
    })
    $('.find').click(function(){
     $('.datable').DataTable().draw(true);
    });
    $('.reset').click(function(){
      $("#name").val('');
      $("#mobile").val('');
      $("#status").val('');
     $('.datable').DataTable().draw(true);
    });

    
  $(function () {
    $(".datable").DataTable({
        "responsive": true,
        "processing": true,
        "serverSide": true,
        "searching": false,
        "order": [[ 0, "desc" ]],
        "ajax": {
          url: "{{route($list_url,['ajax'=>'true'])}}",
          type: 'GET',
          data: function (d) {
            d.mobile = $('#mobile').val();
            d.name = $('#name').val();
            d.status = $('#status').val()
          }
        },
        "columns": [
            {data: 'id', name: 'id'},
            {data: 'name', name: 'name'},
            {data: 'mobile', name: 'mobile'},
            {data: 'status_raw', name: 'status_raw'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ]
    });
    
  });
</script>
@endsection