@extends('layout.layout')
@section('title', 'Create Game')

@section('content')

 <!-- Content Wrapper. Contains page content -->
 <div class="content-wrapper" >
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Add Questions</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Add Questions</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
@if(session('message'))

<div class=" px-5">


  <div class="alert alert-success alert-dismissible fade show mt-5" role="alert">
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
        <span class="sr-only">Close</span>
      </button>
      <strong>{{session('message')}}</strong> 
    </div>
  </div>
 


@endif


@if(count($errors)>0)
<div class=" px-5">
    <div class="alert alert-danger alert-dismissible fade show mt-5" role="alert">
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
        <span class="sr-only">Close</span>
      </button>
      <strong>
      @foreach($errors->all() as $error)
      {{$error}}<br>
      @endforeach
      </strong>
    </div>
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
                <h3 class="card-title">Question here</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form method="POST" enctype="multipart/form-data" >
                  @csrf
                <div class="card-body">
                  <div class="form-group">
                    <label for="exampleInput1">Video Snippet</label>
                    <textarea class="form-control" name="video_code" id="video_code" rows="2" placeholder="Enter video-code here" required></textarea>
                  </div>

                  <div class="form-group">
                    <label for="exampleInput2">Question</label>
                    <textarea class="form-control" name="question" id="question" rows="1" placeholder="Enter question here" required></textarea>
                  </div>

                  <!-- <div class="form-group">
                    <label for="exampleInput3">Answer</label>
                    <textarea class="form-control" name="answer" id="answer" rows="1" placeholder="Enter answer here" required></textarea>
                  </div> -->

                  <div class="form-group">
                    <label for="exampleInput4">Option One</label>
                    <textarea class="form-control" name="option_one" id="option_one" rows="1" placeholder="Enter option one here" required></textarea>
                  </div>

                  <div class="form-group">
                    <label for="exampleInput5">Option Two</label>
                    <textarea class="form-control" name="option_two" id="option_two" rows="1" placeholder="Enter option two here" required></textarea>
                  </div>

                  <div class="form-group">
                    <label for="exampleInput6">Option Three</label>
                    <textarea class="form-control" name="option_three" id="option_three" rows="1" placeholder="Enter option three here" required></textarea>
                  </div>

                  <div class="form-group mb-3">
                    <label for="exampleInput7">Correct Answer</label>
                    <select class="form-control" name="correct_answer" id="correct_answer" required>
                      <option value="1">Option One</option>
                      <option value="2">Option Two</option>
                      <option value="3">Option Three</option>
                    </select>


                  <div class="form-group my-3">
                    <label for="exampleInput6">Difficulty Level</label>
                    <select class="form-control" name="difficulty_level" id="difficulty_level" required>
                      <option value="Easy">Easy</option>
                      <option value="Indermediate">Indermediate</option>
                      <option value="Complex">Complex</option>
                    </select>
                  </div>

                  <div class="form-group">
                        

                  <div class="form-group">
                    <div class="select2-purple">
                    <label for="exampleInput9">Tags</label>
                    <select name="tag[]" id="tag" required class="select2" multiple="multiple" data-placeholder="Select Tags" data-dropdown-css-class="select2-purple" style="width:100%">
                     @foreach($tags as $tag)
                      <option value="{{$tag->id}}">{{$tag->name}}</option>
                    @endforeach
                    </select>
                    </div>
                </div>




                  
                  <!-- <div class="form-group">
                    <label for="exampleInput9">Music</label> <br>
                    <input type="file" name="music_code" id="music_code" accept="audio/*">
                </div> -->

                  <div class="form-group">
                    <label for="exampleInput9">Host</label>
                    <select class="form-control" name="host" id="host" required>
                     @foreach($hosts as $host)
                      <option value="{{$host->id}}">{{$host->name}}</option>
                    @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="exampleInput10">Question Time(in seconds)</label>
                    <input type="number" class="form-control" name="question_time" id="question_time" placeholder="Enter question time here in seconds" value="30" required>
                </div>

                <!-- <div class="form-group">
                    <label for="exampleInput11">Question Success Message</label>
                    <input type="text" class="form-control" name="question_success_message" id="question_success_message" placeholder="Enter question success message here" value="Hurray! your answer is correct" required>
                </div> -->

                <!-- <div class="form-group">
                    <label for="exampleInput12">Question Fail Message</label>
                    <input type="text" class="form-control" name="question_fail_message" id="question_fail_message" placeholder="Enter question fail message here" value="Opps! Wrong answer" required>
                </div> -->



                <!-- /.card-body -->

                <div class="card-footer">
                  <button type="submit" class="btn btn-primary">Add question
            </div>
            <!-- /.card -->

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
$('.select2').select2()

//Initialize Select2 Elements
$('.select2bs4').select2({
  theme: 'bootstrap4'
})
</script>
@endsection

