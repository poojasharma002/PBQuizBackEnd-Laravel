@extends('layout.layout')
@section('title', 'Add Trophy')

@section('content')

 <!-- Content Wrapper. Contains page content -->
 <div class="content-wrapper" >
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Add Trophy</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Add Trophy</li>
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
                <h3 class="card-title">Create Trophy</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <div class="card-body">
              <form action="" method="POST" enctype="multipart/form-data" id="trophy-form">
                  @csrf
                    

                        
                        <div class="form-group">
                            <label for="trophy_name">Trophy Name</label>
                            <input type="text" class="form-control" id="trophy_name" name="trophy_name" placeholder="Enter Trophy Name">
                        </div>  
                        <div class="form-group">
                            <label for="trophy_image">Trophy Image</label>
                            <input type="file" class="form-control" id="trophy_image" name="trophy_image" placeholder="Enter Trophy Image" accept="image/*">
                        </div>
                        <div class="form-group">
                            <label for="trophy_desc">Trophy Description</label>
                            <textarea class="form-control" id="trophy_desc" name="trophy_desc" placeholder="Enter Trophy Description"></textarea>
                        </div>

                        <div class="loader" style="display:none;" id="loader">
                            <i class="fa fa-spinner fa-spin"></i>
                        </div>

                        <div class="card-footer">
                            <input type="submit" value="Submit" class="btn btn-primary ">
                        </div>
                  
                    <!-- /.card -->
                </form>
                <div class="col-md-2"></div>

          </div>
        </div>

        <div class="row">
          <!-- left column -->
          <div class="col-md-12">
          <table class="table table-bordered" id="all-trophies-table">
                <thead>
                    <tr>
                        <th>S.No</th>
                        <th>Trophy Name</th>
                        <th>Trophy Image</th>
                        <th>Trophy Description</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                  @foreach($trophies as $trophy)
                    <tr>
                        <td style="width:5%">{{$loop->iteration}}</td>
                        <td>{{$trophy->trophy_name}}</td>
                        <td><img src="{{$trophy->trophy_image}}" alt="trophy-image" width="100"></td>
                        <td>{{$trophy->trophy_desc}}</td>
                        <td style="width:20%">
                            <a href="javascript:void(0)" class="btn btn-primary " onclick="editFunc(this,{{$trophy->id}})" data-toggle="modal" data-target="#modelId"> <i class="fa fa-edit"></i> </a>
                            <a href="javascript:void(0)" class="btn btn-danger text-light deleteBtn" onclick="deleteFunc(this,{{$trophy->id}})"> <i class="fa fa-trash" aria-hidden="true"></i> </a></td>
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
                  <h5 class="modal-title">Edit Trophy</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                      </button>
              </div>
              <div class="modal-body">
              <form action="" method="POST" enctype="multipart/form-data" id="trophy-form-edit">
                        @method('PUT')
                        @csrf
                    <div class="card-body">

                        <input type="hidden" name="edit_id" id="edit-id">
                        <div class="form-group">
                            <label for="trophy_name">Trophy Name</label>
                            <input type="text" class="form-control" id="trophy_name_edit" name="trophy_name_edit" placeholder="Enter Trophy Name" required>
                        </div>

                        <div class="form-group">
                            <label for="trophy_image">Trophy Image</label>
                            <input type="file" class="form-control" id="trophy_image_edit" name="trophy_image_edit" accept="image/*">
                        </div>

                        <div class="form-group">
                            <label for="trophy_desc">Trophy Description</label>
                            <textarea class="form-control" id="trophy_desc_edit" name="trophy_desc_edit" placeholder="Enter Trophy Description"></textarea>
                        </div>
                        </div>
    
                        <input type="submit" value="Submit" class="btn btn-primary ">
                    <!-- /.card -->
                </form>

              </div>
              <div class="modal-footer">
               
              </div>
          </div>
      </div>
  </div>
<script>
$(document).ready(function() {
  $('#all-trophies-table').DataTable();
  } 
);

var id = '';
window.addEventListener('keydown',function(e){if(e.keyIdentifier=='U+000A'||e.keyIdentifier=='Enter'||e.keyCode==13){if(e.target.nodeName=='INPUT'&&e.target.type=='text'){e.preventDefault();return false;}}},true);

function editFunc(this_para,id){
    var trophy_name = $(this_para).closest('tr').find('td:eq(1)').text();
    var trophy_description = $(this_para).closest('tr').find('td:eq(3)').text();
    $('#trophy_name_edit').val(trophy_name);
    $('#trophy_desc_edit').val(trophy_description);
    $('#edit-id').val(id);
     id = id;
    // var trophy_image = $(this_para).closest('tr').find('td:eq(2)').find('img').attr('src');
    // alert(trophy_image);
    // $('#trophy_image_edit').val(trophy_image_edit);
}
  //addFunc 
$(document).ready(function() {
  $('#trophy-form').submit(function(e){
      e.preventDefault();
      var trophy_name = document.getElementById('trophy_name').value;
      var trophy_name = document.getElementById('trophy_image').value;
      var trophy_desc = document.getElementById('trophy_desc').value;

      if(trophy_name === '' || trophy_desc === '' || trophy_image === ''){
        swal({
              title: "Error!",
              text: "Please Enter Trophy Details",
              icon: "error",
              button: "Ok",
          });
      }
      //check if only image is uploaded or not
      var file = $('#trophy_image').prop('files')[0];
      var file_name = file.name;
      var file_ext = file_name.split('.').pop().toLowerCase();
      if(file_ext != 'jpg' && file_ext != 'jpeg' && file_ext != 'png' && file_ext != 'gif'){
          swal({
              title: "Error!",
              text: "Please upload image file only!",
              icon: "error",
              button: "Ok",
          });
          return false;
      }

      var formData = new FormData(this);
      var url = "{{url('add_trophy') }}";
          e.preventDefault();
      $.ajax({
          url: url,
          type: 'POST',
          data: formData,
          cache: false,
          contentType: false,
          processData: false,
          beforeSend: function(){
              $('#loader').removeAttr('style');
          },

          success: function (data) {
            $('#loader').attr('style','display:none');
              $('#loader').attr('style','display:none');
              swal("Trophy Uploaded Successfully","","success")
                .then((value) => {
                  location.reload();
                });

          },
          error: function (data) {
              $('#loader').attr('style','display:none');
              swal("Error Occured while adding trophy. Please try again","","warning")
                .then((value) => {
                  location.reload();
                });
          }
      });
  });

  $('#trophy-form-edit').submit(function(e){
      e.preventDefault();

    //get the trophy_name and trophy_image of the edit form
    var trophy_name = $('#trophy_name_edit').val();
    
      var formData = new FormData(this);

      var url = "{{url('edit_trophy')}}";
          e.preventDefault();
      $.ajax({
          url: url,
          type: 'POST',
          data: formData,
          cache: false,
          contentType: false,
          processData: false,
          beforeSend: function(){
              $('#loader').removeAttr('style');
          },

          success: function (data) {
            $('#loader').attr('style','display:none');
              $('#loader').attr('style','display:none');
              swal("Trophy Updated Successfully","","success")
                .then((value) => {
                  location.reload();
                });

          },
          error: function (data) {
              $('#loader').attr('style','display:none');
              swal("Error Occured while updating trophy. Please try again","","warning")
                .then((value) => {
                  location.reload();
                });
          }
      });
  });
});

// function editFunc(this_para,id){
//   //disable enter key

//     //get the value of the trophy name
//     var trophy_name = $(this_para).closest('tr').find('td:eq(1)').text();
//     //set the value of the trophy name
//     $('#trophy_name_edit').val(trophy_name);
    
//     //get the value of the trophy image
//     var trophy_image = $(this_para).closest('tr').find('td:eq(2)').find('img').attr('src');
  
// //on click of update-btn update the Host name in the database
//     $('#update-btn').click(function(){

//         var trophy_name_edit = $('#trophy_name_edit').val();
//         $.ajax({
//             url: "{{url('edit_trophy') }}",
//             type: 'PUT',
//             data: {
//                 _token: "{{csrf_token()}}" , 
//                 trophy_name_edit: trophy_name_edit,
//                 id: id
//             },
//             success: function(data){
//                 //close the modal
//                 $('#modelId').modal('hide');
//                 //update the Host name in the table
//                 $(this_para).closest('tr').find('td:eq(1)').text(host_name_edit);
//                 //show the success message
//                 alert('Trophy Updated Successfully');
//                 location.reload();
//             }
//         });
//     });
// }

function deleteFunc(this_para,id){
        var id = id;
        swal({
          title: "Are you sure you want to delete Trophy?",
          icon: "warning",
          buttons: true,
          dangerMode: true,
        })
        .then((willDelete) => {
          if (willDelete) {
           
            // ajax
              $.ajax({
              type:"post",
              url: "{{ url('delete_trophy') }}",
              data: { _token: "{{csrf_token()}}" , id: id },
              dataType: 'json',
                  success: function(res){
                    if(res.deleted == 0){
                      swal(res.message,"","warning");
                    }else{
                      $(this_para).closest('tr').remove();
                          swal("Trophy Deleted Successfully","","success")
                            .then((value) => {
                              location.reload();
                            });
                    }
                         
                  }
              });
          }
        });

}





</script>

@endsection

