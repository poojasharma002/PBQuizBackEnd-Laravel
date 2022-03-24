@extends('layout.layout')
@section('title', 'Edit Question')

@section('content')
<!-- Content Wrapper. Contains page content -->
 <div class="content-wrapper" >
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Edit Question</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Edit Questions</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

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
              <form action="" method="POST">
                @method('PUT')
                  @csrf

                <div class="card-body">
                  <div class="form-group">
                    <label for="exampleInput1">Video Snippet</label>
                    <textarea class="form-control" name="video_code" id="video_code" rows="2" placeholder="Enter video-code here" required>{{$question->video_code}}</textarea>
                  </div>

                  <div class="form-group">
                    <label for="exampleInput2">Question</label>
                    <textarea class="form-control" name="question" id="question" rows="1" placeholder="Enter question here" required>{{$question->question}}</textarea>
                  </div>


                  <div class="form-group">
                    <label for="exampleInput4">Option One</label>
                    <textarea class="form-control" name="option_one" id="option_one" rows="1" placeholder="Enter option one here" required>{{$question->option_one}}</textarea>
                  </div>

                  <div class="form-group">
                    <label for="exampleInput5">Option Two</label>
                    <textarea class="form-control" name="option_two" id="option_two" rows="1" placeholder="Enter option two here" required>{{$question->option_two}}</textarea>
                  </div>

                  <div class="form-group">
                    <label for="exampleInput6">Option Three</label>
                    <textarea class="form-control" name="option_three" id="option_three" rows="1" placeholder="Enter option three here" required>{{$question->option_three}}</textarea>
                  </div>

                  <div class="form-group">
                    <label for="exampleInput7">Correct Answer</label>
                    <select class="form-control" name="correct_answer" id="correct_answer" required>
                      <option value="1" @if($question->correct_answer == 1) selected @endif>Option One</option>
                      <option value="2" @if($question->correct_answer == 2) selected @endif>Option Two</option>
                      <option value="3" @if($question->correct_answer == 3) selected @endif>Option Three</option>
                    </select>

                  </div>


                  <div class="form-group mb-3">
                    <label for="exampleInput6">Difficulty Level</label>
                    <select class="form-control" name="difficulty_level" id="difficulty_level" required>
                      <option value="Easy" @if($question->difficulty_level === "Easy") selected @endif >Easy</option>
                      <option value="Indermediate" @if($question->difficulty_level === "Indermediate") selected @endif >Indermediate</option>
                      <option value="Complex" @if($question->difficulty_level === "Complex") selected @endif >Complex</option>
                    </select>


                  <div class="form-group">
                    <div class="select2-purple">
                    <label for="exampleInput9">Tags</label>
                    <select name="tag[]" id="tag" required class="select2" multiple="multiple" data-placeholder="Select qustions" data-dropdown-css-class="select2-purple" style="width:100%" required>
       
                      @foreach($tags as $tag)
                      <option value="{{$tag->id}}">{{$tag->name}}</option>
                      @endforeach
                    
                    
                    </select>
                    </div>
                </div>

        
                  <div class="form-group">
                    <label for="exampleInput9">Host</label>
                    <select class="form-control" name="host" id="host" required>
                    @foreach($hosts as $host)
                      <option value="{{$host->id}}"  @if($host_name == $host->name) selected @endif>{{$host->name}}</option>
                    @endforeach
                      
                    </select>
                </div>

                <div class="form-group">
                    <label for="exampleInput10">Question Time</label>
                    <input type="number" class="form-control" name="question_time" id="question_time" placeholder="Enter question time here in seconds" value="{{$question->question_time}}" required>
                </div>


                <div class="card-footer">
                  <button type="submit" class="btn btn-primary">Update question</button>
                </div>

            </form>
            <!-- /.card -->
         
      

            <div class="col-md-2"></div>

          </div>
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
  </div>
  <!-- /.content-wrapper -->

  <script>
$('.select2').select2();

//Initialize Select2 Elements
$('.select2bs4').select2({
  theme: 'bootstrap4'
});


//in edit question page select the default value of the tag

var tag_name_object = [];
tag_name_object   = @json($tag_name_array);

var tag_name_array = [];
var tag_id_array = [];
for(var i=0; i<tag_name_object.length; i++){
  tag_name_array.push(tag_name_object[i].name);
  tag_id_array.push(tag_name_object[i].id);
}

var tag_select = $('#tag');

for(var i = 0; i < tag_id_array.length; i++){
  tag_select.find('option').each(function(){
    if($(this).val() == tag_id_array[i]){
      $(this).attr('selected', 'selected');
      $(this).prop('selected', true);
      $(this).parent().trigger('change');
    }
  });
}


</script>

@endsection

