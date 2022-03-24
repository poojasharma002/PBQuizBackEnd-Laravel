@extends('layout.layout')
@section('title', 'Add Music')

@section('content')

 <!-- Content Wrapper. Contains page content -->
 <div class="content-wrapper" >
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Add Music</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Add Music</li>
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
                <h3 class="card-title">Create Music</h3>


              </div>
              <!-- /.card-header -->
                <div class="card-body">
                    <div class="form-group">
                    <label for="tag_name">Select Audio Option</label>
                    <select class="form-control" id="music_option" name="music_option" onchange="checkFunc()">
                        <option value="For Success">For Success</option>
                        <option value="For Failure">For Failure</option>
                    </select>
                    </div>
                </div>

                 
              <!-- form start -->
                <form action="" method="POST" id="success-form" enctype="multipart/form-data" >
                  @csrf
                    <div class="card-body">     
                        <div class="form-group" id="success_audio_form">
                            <label for="tag_name">Select Success Sound</label>
                            <input type="file" class="form-control" id="success_audio" name="success_audio" placeholder="" accept="audio/*">
                        </div>  

                        <div class="form-group" id="failure_audio_form" style="display:none">
                            <label for="tag_name">Select Failure  Sound</label>
                            <input type="file" class="form-control" id="failure_audio" name="failure_audio" placeholder="" accept="audio/*">
                        </div>  

                        
                        <div class="loader" style="display:none;" id="loader">
                            <i class="fa fa-spinner fa-spin"></i>
                        </div>


                        <div class="card-footer">
                       
                            <!-- <a href="javascript:void(0)" class="btn btn-primary " onclick="addFunc(this)" > Add </a> -->
                            <input type="submit" value="Submit" class="btn btn-primary ">
                            <!-- <button  class="btn btn-primary " type="submit"> Submit </button> -->
                        </div>
                    </div>
                    <!-- /.card -->
                </form>

                <!-- <form action="" method="POST" id="failure-form" style="display:none">
                  @csrf
                    <div class="card-body ">

                        
                        <div class="form-group">
                            <label for="tag_name">Select Failure  Sound</label>
                            <input type="file" class="form-control" id="tag_name" name="tag_name" placeholder="" accept="audio/*">
                        </div>  

                        <div class="card-footer">
                   
                        <a href="javascript:void(0)" class="btn btn-primary " onclick="addFunc(this)" > Add </a>
                        </div>

                </form> -->
                </div>

            </div>

                <div class="col-md-2"></div>



          </div>
        </div>

        <div class="row">
            <div class="col-md-2"></div>
          <!-- left column -->
          <div class="col-md-8">
          <table class="table table-bordered" id="all-musics-table">
                <thead>
                    <tr>
                        <th>S.No</th>
                        <th>Music</th>
                        <th>Type</th>
                    </tr>
                </thead>
                <tbody>
                @if(!empty($musics))
                @foreach($musics as $music)
                    <tr>
                        <td style="width:5%">{{$loop->iteration}}</td>
                        <td>
                        <audio controls>
                            <source src="{{$music->name}}" >
                            </audio>
                        </td>
                        <td>
                            @if($music->type == 'success_audio')
                                Success Audio
                            @else
                                Failure Audio
                            @endif
                        </td>
            
                    </tr>
                  @endforeach
                @endif
                </tbody>
            </table>
            </div><!-- /.col -->
            
            <div class="col-md-2"></div>
            </div><!-- /.row -->
          </div>

          <div class="col-md-2"></div>
        </div>


          </div>
        </div>

        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  

<script>
$(document).ready(function() {
  $('#all-musics-table').DataTable();
  } 
);

$(document).ready(function() {
    $('#success-form').submit(function(e){
        var formData = new FormData(this);

        //check which option is selected
        var option = $('#music_option').val();
        if(option == 'For Success'){
            $('#failure_audio').val('');
        }else{
            $('#success_audio').val('');
        }
        
        //check if success_audio is empty
        if($('#success_audio').val() == ''){
            formData.delete("success_audio");
        }
        //check if failure_audio is empty
        if($('#failure_audio').val() == ''){
            formData.delete("failure_audio");
        }

        var url = "{{url('add_music') }}";
        e.preventDefault();
            var audio_type= $('#music_option').val();
            //append audio type to form data   
            formData.append('audio_type',audio_type);
        $.ajax({
            url: url,
            type: 'POST',
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            beforeSend: function(){
                //remove style display none from loader
                $('#loader').removeAttr('style');

            },

            success: function (data) {
                $('#loader').attr('style','display:none');
                swal("Audio Added Successfully","","success")
                .then((value) => {
                  location.reload();
                });
             
                //page refresh
                
            },
            error: function (data) {
                $('#loader').attr('style','display:none');
                swal("Error Occured while uploading audio. Please try again","","warning")
                .then((value) => {
                  location.reload();
                });
            }
        });
    });
});

//create function if in music_option for success option is selected then show the success-form 
function checkFunc(){
    //hide both the form
    
        var music_option = $('#music_option').val();
        if(music_option == 'For Success'){
             $('#success_audio_form').show();
        }else{
            $('#success_audio_form').hide();
        }
    
        //if For Failure is selected then show the failure-form
        if(music_option == 'For Failure'){
            $('#failure_audio_form').show();
        }else{
            $('#failure_audio_form').hide();
        }
    
    
}

  

</script>

@endsection

