@extends('layout.layout')
@section('title', 'Add Tags')

@section('content')

 <!-- Content Wrapper. Contains page content -->
 <div class="content-wrapper" >
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Add Tags</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Add Tags</li>
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
                <h3 class="card-title">Create Tag</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form action="" method="POST">
                  @csrf
                    <div class="card-body">

                        
                        <div class="form-group">
                            <label for="tag_name">Tag Name</label>
                            <input type="text" class="form-control" id="tag_name" name="tag_name" placeholder="Enter Tag Name" required>
                        </div>  

                        <div class="card-footer">
                        <!-- <button type="submit" class="btn btn-primary">Add Tag</button> -->
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
          <table class="table table-bordered" id="all-tags-table">
                <thead>
                    <tr>
                        <th>S.No</th>
                        <th>Tag Name</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                  @foreach($tags as $tag)
                    <tr>
                        <td style="width:5%">{{$loop->iteration}}</td>
                        <td>{{$tag->name}}</td>
                        <td style="width:20%">
                            <a href="javascript:void(0)" class="btn btn-primary " onclick="editFunc(this,{{$tag->id}})" data-toggle="modal" data-target="#modelId"> <i class="fa fa-edit"></i> </a>
                            <a href="javascript:void(0)" class="btn btn-danger text-light deleteBtn" onclick="deleteFunc(this,{{$tag->id}})"> <i class="fa fa-trash" aria-hidden="true"></i> </a></td>
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
                  <h5 class="modal-title">Edit Tag</h5>
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
                            <label for="tag_name">Tag Name</label>
                            <input type="text" class="form-control" id="tag_name_edit" name="tag_name_edit" placeholder="Enter Tag Name" value="">
                        </div>
                    </div>

                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                      <button type="button" class="btn btn-primary" id="update-btn">Update</button>
                  </div>
                    <!-- /.card -->
                </form>

              </div>
          
          </div>
      </div>
  </div>
  <script>
  window.addEventListener('keydown',function(e){if(e.keyIdentifier=='U+000A'||e.keyIdentifier=='Enter'||e.keyCode==13){if(e.target.nodeName=='INPUT'&&e.target.type=='text'){e.preventDefault();return false;}}},true);
    //addFunc 
function addFunc(elem){


    var tag_name = $('#tag_name').val();

    if(tag_name === "" ){
      swal({
          title: "Please Enter Tag",
          icon: "warning",
          dangerMode: true,
        })
    }
    var url = "{{url('add_tag') }}";
    $.ajax({
        url: url,
        type: 'POST',
        data: {
            tag_name: tag_name,
            _token: "{{csrf_token()}}"
        },
        success: function(data){

          location.reload();
            // console.log(data);
            // //get number of rows
            // var rowCount = $('#all-questions-table tr').length;
            // //add row to table
            // var row = '<tr><td style="width:5%">'+ rowCount+'</td><td>'+data.tag_name+'</td><td style="width:20%"><a href="javascript:void(0)" class="btn btn-primary " onclick="editFunc(this,'+data.id+')" data-toggle="modal" data-target="#modelId"> <i class="fa fa-edit"></i> </a> <a href="javascript:void(0)" class="btn btn-danger text-light deleteBtn" onclick="deleteFunc(this,'+data.id+')"> <i class="fa fa-trash" aria-hidden="true"></i> </a></td></tr>';
            // $('#all-questions-table tbody').append(row);
            // //clear input
            // $('#tag_name').val('');
          // alert('Tag Added Successfully');
        }
    });
}

function editFunc(this_para,id){
    //get the value of the tag name
    var tag_name = $(this_para).closest('tr').find('td:eq(1)').text();
    //set the value of the tag_name_edit
    $('#tag_name_edit').val(tag_name);
    
//on click of update-btn update the tag name in the database
$('#update-btn').click(function(e){
    var tag_name_edit = $('#tag_name_edit').val();

    if(tag_name_edit == ''){
            swal("Please Enter Host Name",'','error');
            return false;
        }
    $.ajax({
        url: "{{url('edit_tag')}}",
        type: 'PUT',
        data: {
             _token: "{{csrf_token()}}" , 
            tag_name_edit: tag_name_edit,
            id: id
        },
        success: function(data){
            $('#modelId').modal('hide');
            $(this_para).closest('tr').find('td:eq(1)').text(tag_name_edit);
            swal({
                title: "Tag Updated successfully",
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
          title: "Are you sure you want to delete tag?",
          icon: "warning",
          buttons: true,
          dangerMode: true,
        })
        .then((willDelete) => {
          if (willDelete) {

            // ajax
                $.ajax({
                type:"post",
                url: "{{ url('delete_tag') }}",
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
                                swal("Tag deleted successfully", {
                                  icon: "success",
                                });
                            }
                    }
                }); 
          }
        });
}
       

// add data table 
$(document).ready(function() {
  $('#all-tags-table').DataTable();
  } 
);


</script>

@endsection

