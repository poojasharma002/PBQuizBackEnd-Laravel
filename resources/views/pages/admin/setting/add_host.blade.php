@extends('layout.layout')
@section('title', 'Add Host')

@section('content')

 <!-- Content Wrapper. Contains page content -->
 <div class="content-wrapper" >
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Add Host</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Add Host</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
@if(session('message'))

    <div class="alert alert-success alert-dismissible fade show mt-5" role="alert">
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
        <span class="sr-only">Close</span>
      </button>
      <strong>{{session('message')}}</strong> 
    </div>

@endif

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <!-- left column -->
          <div class="col-md-2"></div>
          <div class="col-md-8">
            <!-- general form elements -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Create Host</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form action="" method="POST">
                  @csrf
                    <div class="card-body">

                        
                        <div class="form-group">
                            <label for="host_name">Host Name</label>
                            <input type="text" class="form-control" id="host_name" name="host_name" placeholder="Enter Host Name">
                        </div>  

                        <div class="card-footer">
                        <!-- <button type="submit" class="btn btn-primary">Add Host</button> -->
                        <a href="javascript:void(0)" class="btn btn-primary " onclick="addFunc(this)" > Add </a>
                        </div>
                    <!-- /.card -->
                </form>
                <div class="col-md-2"></div>

          </div>
        </div>

        <div class="row">
          <!-- left column -->
          <div class="col-md-12">
          <table class="table table-bordered" id="all-hosts-table">
                <thead>
                    <tr>
                        <th>S.No</th>
                        <th>Host Name</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                  @foreach($hosts as $host)
                    <tr>
                        <td style="width:5%">{{$loop->iteration}}</td>
                        <td>{{$host->name}}</td>
                        <td style="width:20%">
                            <a href="javascript:void(0)" class="btn btn-primary " onclick="editFunc(this,{{$host->id}})" data-toggle="modal" data-target="#modelId"> <i class="fa fa-edit"></i> </a>
                            <a href="javascript:void(0)" class="btn btn-danger text-light deleteBtn" onclick="deleteFunc(this,{{$host->id}})"> <i class="fa fa-trash" aria-hidden="true"></i> </a></td>
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
  <!-- Button trigger modal -->

  
  <!-- Modal -->
  <div class="modal fade" id="modelId" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
      <div class="modal-dialog" role="document">
          <div class="modal-content">
              <div class="modal-header">
                  <h5 class="modal-title">Edit Host</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                      </button>
              </div>
              <div class="modal-body">
              <form action="" method="POST">
              @method('PUT')
              @csrf
                    <div class="card-body">

                        
                        <div class="form-group">
                            <label for="Host_name">Host Name</label>
                            <input type="text" class="form-control" id="host_name_edit" name="host_name_edit" placeholder="Enter Host Name" >
                        </div>
                      </div>

                    <!-- /.card -->
                </form>

              </div>
              <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                  <button type="button" class="btn btn-primary" id="update-btn">Update</button>
              </div>
          </div>
      </div>
  </div>
  <script>
$(document).ready(function() {
  $('#all-hosts-table').DataTable();
  } 
);

  window.addEventListener('keydown',function(e){if(e.keyIdentifier=='U+000A'||e.keyIdentifier=='Enter'||e.keyCode==13){if(e.target.nodeName=='INPUT'&&e.target.type=='text'){e.preventDefault();return false;}}},true);


    //addFunc 
function addFunc(elem){
  //disable enter button

    var host_name = $('#host_name').val();
    var url = "{{url('add_host') }}";
    $.ajax({
        url: url,
        type: 'POST',
        data: {
            host_name: host_name,
            _token: "{{csrf_token()}}"
        },
        success: function(data){
            location.reload();
            // console.log(data);
            // //get number of rows
            // var rowCount = $('#all-questions-table tr').length;
            // //add row to table
            // var row = '<tr><td style="width:5%">'+ rowCount+'</td><td>'+data.host_name+'</td><td style="width:20%"><a href="javascript:void(0)" class="btn btn-primary " onclick="editFunc(this,'+data.id+')" data-toggle="modal" data-target="#modelId"> <i class="fa fa-edit"></i> </a> <a href="javascript:void(0)" class="btn btn-danger text-light deleteBtn" onclick="deleteFunc(this,'+data.id+')"> <i class="fa fa-trash" aria-hidden="true"></i> </a></td></tr>';
            // $('#all-questions-table tbody').append(row);
            // //clear input
            // $('#host_name').val('');
            // alert('Host Added Successfully');

        }
    });
}

function editFunc(this_para,id){
    var host_name = $(this_para).closest('tr').find('td:eq(1)').text();
    $('#host_name_edit').val(host_name);
//on click of update-btn update the Host name in the database
    $('#update-btn').click(function(){

        var host_name_edit = $('#host_name_edit').val();
        $.ajax({
            url: "{{url('edit_host') }}",
            type: 'PUT',
            data: {
                _token: "{{csrf_token()}}" , 
                host_name_edit: host_name_edit,
                id: id
            },
            success: function(data){
                $('#modelId').modal('hide');
                $(this_para).closest('tr').find('td:eq(1)').text(host_name_edit);
                swal({
                    title: "Host Updated Successfully",
                    icon: "success",
                  })
                  .then((value) => {
                    location.reload();
                  });
            }
        });
    });
}

function deleteFunc(this_para,id){    
  var id = id;
   swal({
          title: "Are you sure you want to delete Host?",
          icon: "warning",
          buttons: true,
          dangerMode: true,
        })
        .then((willDelete) => {
          if (willDelete) {
                $.ajax({
                type:"post",
                url: "{{ url('delete_host') }}",
                data: { _token: "{{csrf_token()}}" , id: id },
                dataType: 'json',
                    success: function(res){
                        if(res.deleted == 0){
                            swal({
                                title: res.message,
                                icon: "warning",
                              })
                        }else{
                          $(this_para).closest('tr').remove();
                            swal("Host deleted successfully", {
                              icon: "success",
                            });
                        }
                            
                    }
                }); 
          }
        });

    
}





</script>

@endsection

