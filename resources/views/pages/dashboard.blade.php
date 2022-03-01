@extends('layout.layout')
@section('title', 'Dashboard')
 
@section('content')
 <!-- Content Wrapper. Contains page content -->
 <div class="content-wrapper" >
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Dashboard</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Dashboard v1</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row">
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <a href="{{url('all-questions')}}">
            <div class="small-box" style="background:#c2d5ff">
              <div class="inner p-3 py-5">
              <h3 class="text-dark" style="font-weight:400">Questions</h3>

                <p></p>
                
              </div>
              <div class="icon " style="background:#c2d5ff">
                <i class="fa fa-question-circle text-dark" style="font-size:3.2rem"></i>
              </div>
              <a href="{{url('all-questions')}}" class="small-box-footer" style="background:#3988ff">  <i class="fas fa-arrow-circle-right fa-2x text-dark"></i></a>
            </div>
            </a>
          </div>
     
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <a href="{{url('all_games')}}">
            <div class="small-box " style="background:#ecc797">
              <div class="inner p-3 py-5">
              <h3 class="text-dark" style="font-weight:400">Games</h3>

                <p></p>
                
              </div>
              <div class="icon">
                <i class="fa fa-gamepad text-dark" style="font-size:3.2rem"></i>
              </div>
              <a href="{{url('all_games')}}" class="small-box-footer" style="background:#f59d2b">  <i class="fas fa-arrow-circle-right fa-2x text-dark"></i></a>
            </div>
            </a>
          </div>
        
          <!-- ./col -->
        
          <!-- ./col -->

       

 
        </div>
        <!-- /.row -->


      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
@endsection