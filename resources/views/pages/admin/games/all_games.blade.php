@extends('layout.layout')
@section('title', 'All Games')

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
              <li class="breadcrumb-item active">All Games</li>
            </ol>
   
          </div><!-- /.col -->
    
        </div><!-- /.row -->

        <span class="m-0" style="font-size:2rem">All Games</span>  
        <span class=" float-sm-right">  <a href="{{url('create_game')}}" class="py-3 btn btn-primary mt-3 float-right"><i class="fa fa-plus" aria-hidden="true"></i> Add Games</a></span>
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

@if(session('success'))

<div class="alert alert-primary alert-dismissible fade show" role="alert">
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
    <span class="sr-only">Close</span>
  </button>
  <strong>{{session('success')}}</strong> 
</div>

@endif



    <!-- Main content -->
    <section class="content mt-5">
      <div class="container-fluid">
        <div class="row">
          <!-- left column -->
          <div class="col-md-12" style="overflow-x : auto;">
                <table class="table table-bordered" id="all-games-table">
                        <thead>
                            <tr>
                                <th >S.No</th>
                                <th>Game Name</th>
                                <th>Game Type</th>
                                <th>Level</th>
                                <!-- <th>Tag</th> -->
                                <th>Game Image</th>
                                <th>Trophy</th>
                                <th>Published</th>
                                <!-- <th>Published</th> -->
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($data as $game)
                            <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>{{$game['games']->gamename}}</td>
                            <td>{{$game['games']->gametype}}</td>
                            <td>{{$game['games']->level}}</td>
                           
                            <td><img src="{{$game['games']->game_image}}" alt="{{$game['games']->game_image}}" width="100px" height="100px"></td>
                            <td>{{$game['trophy']->trophy_name}}</td>

                            <td>
                                <input type="checkbox" id="published-checkbox" class="form-control" data-id="{{$game['games']->id}}" data-toggle="toggle" data-on="Published" data-off="Unpublished" data-onstyle="success" data-offstyle="danger" {{$game['games']->published == '1' ? 'checked' : ''}} onclick="publishFunc(this,{{$game['games']->id}})">
                            </td>

                            <td>
                                <a href="{{url('edit_game/'.$game['games']->id)}}" class="btn btn-primary"><i class="fa fa-edit" aria-hidden="true"></i></a>
                                <a href="javascript:void(0)" class="btn btn-danger text-light deleteBtn" onclick="deleteFunc(this,{{$game['games']->id}})"> <i class="fa fa-trash" aria-hidden="true"></i> </a>
                            </td>
                            </tr>
                            @endforeach
                            
                           

                        </tbody>
                </table>
          </div><!-- /.col -->
        </div><!-- /.row -->

            <div class="col-md-2"></div>
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
 
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->


  
  <script>

$(document).ready(function() {
  $('#all-games-table').DataTable({
    // "sScrollX": '100%'
  });
  } 
);


// PUBLISH GAME FUNCTION

function publishFunc(this_para,id){
  
  var id = id;
  var published = $(this_para).prop('checked');
  var published = published ? 1 : 0;
  // ajax
  $.ajax({
  type:"post",
  url: "{{ url('publish/game') }}",
  data: { _token: "{{csrf_token()}}" , id: id , published: published },
  dataType: 'json',
      success: function(res){
              alert('Game published successfully');
      }
  });
}

//DELETE GAME FUNCTION

function deleteFunc(this_para,id){
  var id = id;
   swal({
          title: "Are you sure you want to delete game?",
          icon: "warning",
          buttons: true,
          dangerMode: true,
        })
        .then((willDelete) => {
          if (willDelete) {
           
            // ajax
                $.ajax({
                type:"post",
                url: "{{ url('delete/game') }}",
                data: { _token: "{{csrf_token()}}" , id: id },
                dataType: 'json',
                    success: function(res){
                            $(this_para).closest('tr').remove();
                            swal("Game deleted successfully", {
                              icon: "success",
                            });
                    }
                }); 
          }
        });

}



</script>
@endsection