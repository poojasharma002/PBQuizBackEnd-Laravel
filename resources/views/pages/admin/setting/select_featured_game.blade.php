@extends('layout.layout')
@section('title', 'Select Featured Game')

@section('content')

 <!-- Content Wrapper. Contains page content -->
 <div class="content-wrapper" >
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Select Featured Game</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Select Featured Game</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
@if(session('success'))

    <div class="alert alert-success alert-dismissible fade show mt-5" role="alert">
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
        <span class="sr-only">Close</span>
      </button>
      <strong>{{session('success')}}</strong> 
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
                <h3 class="card-title">Select Featured Game</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <div class="card-body">
              <form action="" method="POST" enctype="multipart/form-data" id="featured-game-form">
                  @csrf
                    <div class="form-group">
                        <label for="featured_game">Featured Game</label>
                        
               
                        <select name="featured_game" id="featured_game" class="form-control">
                            <option value="">Select Featured Game</option>
                            @foreach($games as $game)
                            <option value="{{$game->id}}" {{$game->id == $featured_game_id? 'selected' : ''}}>{{$game->gamename}}</option>
                            @endforeach
                        </select>

                    </div>
                    

                    

                        <div class="card-footer">
                            <input type="submit" value="Submit" class="btn btn-primary ">
                        </div>
                  
                    <!-- /.card -->
                </form>
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

  


@endsection

