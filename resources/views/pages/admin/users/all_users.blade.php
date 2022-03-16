@extends('layout.layout')
@section('title', 'All Users')

@section('content')
 <!-- Content Wrapper. Contains page content -->
 <div class="content-wrapper" >
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6 mt-5">

          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">All <i class="fa fa-user-secret" aria-hidden="true"></i></li>
            </ol>
   
          </div><!-- /.col -->
    
        </div><!-- /.row -->

        <span class="m-0" style="font-size:2rem">All Users</span>  
        <!-- <span class=" float-sm-right">  <a href="{{url('add_user')}}" class="py-3 btn btn-primary mt-3"><i class="fa fa-plus" aria-hidden="true"></i> Add user</a></span> -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

@if(session('success'))

<div class="px-5">
<div class="alert alert-success my-3 px-5 alert-dismissible fade show" role="alert">
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true" class="text-white" style="color:#fff">&times;</span>
    <span class="sr-only">Close</span>
  </button>
  <strong>{{session('success')}}</strong> 
</div>
</div>

@endif



    <!-- Main content -->
    <section class="content mt-5">
      <div class="container-fluid">
        <div class="row">
          <!-- left column -->
          <div class="col-md-12">
          <table class="table table-bordered" id="all-users-table">
                <thead>
                    <tr>
                        <th >S.No</th>
                        <th>User</th>
                        <th>Email</th>
                        <th>Profile</th>
                        <th>Status</th>
                        <!-- <th>Delete</th> -->
                    </tr>
                </thead>
                <tbody>
                    @foreach($data as $user)
                    <tr>
                        <td style="width:5%">{{$loop->iteration}}</td>
                        <td>{{$user->name}}</td>
                        <td>{{$user->email}}</td>
                        <td ><img style="width:100px" src="{{$user->profile_pic}}"></td>
         
                        <td>
                            @if($user->status == 1)
                            <a href="{{url('/change_status/'.$user->id)}}" class="btn btn-primary" >Active</a>
                            @else
                            <a href="{{url('/change_status/'.$user->id)}}" class="btn btn-danger" style="filter:brightness(50%)">Deactive</a>
                            @endif
                        </td>
                        <!-- <td style="width:10%">
                        <a href="javascript:void(0)" class="btn btn-danger text-light deleteBtn" onclick="deleteFunc(this,{{$user->id}})"> <i class="fa fa-trash" aria-hidden="true"></i> </a></td> -->
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            </div><!-- /.col -->
            </div><!-- /.row -->



           

            <div class="col-md-2"></div>

          </div>
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->


  <script>

    //active and deactive user


    function deleteFunc(this_para,id){
      var id = id;
   swal({
          title: "Are you sure you want to delete user?",
          icon: "warning",
          buttons: true,
          dangerMode: true,
        })
        .then((willDelete) => {
          if (willDelete) {
                $.ajax({
                type:"post",
                url: "{{ url('delete/user') }}",
                data: { _token: "{{csrf_token()}}" , id: id },
                dataType: 'json',
                    success: function(res){
                            $(this_para).closest('tr').remove();
                            swal("user deleted successfully", {
                              icon: "success",
                            });
                    }
                }); 
          }
        });
    }



    // add data table 
    $(document).ready(function() {
    $('#all-users-table').DataTable();
    } 
    );

</script>


@endsection