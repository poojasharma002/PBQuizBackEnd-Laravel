@extends('layout.layout')
@section('title', 'Edit Game')

@section('content')
 <!-- Content Wrapper. Contains page content -->
 <div class="content-wrapper" >
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Edit Game</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Edit Game</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
     <!-- MultiStep Form -->
<div class="container-fluid" id="grad1">
    <div class="row justify-content-center mt-0">
        <div class="col-12 text-center p-0 mt-3 mb-2">
            <div class="card px-0 pt-4 pb-0 mt-3 mb-3">
                <div class="row">
                    <div class="col-md-1"></div>
                    <div class="col-md-10 mx-0">
                        <form id="msform" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <!-- progressbar -->
                            <ul id="progressbar">
                                <li class="active" id="account"><strong>Game</strong></li>
                                <li id="personal"><strong>Upload</strong></li>
                                <li id="payment"><strong>Add Questions</strong></li>
                                <li id="confirm"><strong>Finish</strong></li>
                            </ul> <!-- fieldsets -->
                            <fieldset>
                                <div class="form-card">
                                    <h2 class="fs-title">Game Information</h2>
                                
                                    <div class="form-group">
                                        <label for="game_name">Game Name</label>
                                        <input type="text" class="form-control" id="gamename" placeholder="Enter Game Name" name="gamename" value="{{$game->gamename}}">
                                    </div>

                                    <div class="form-group">
                                        <label for="exampleFormControlSelect1">Game Type</label>
                                        <select class="form-control" id="gametype" onchange="multiplayerCheck()" name="gametype">
                                            <option @if($game->gametype == "Single Player") selected @endif>Single Player</option>
                                            <option @if($game->gametype == "Multi Player") selected @endif>Multi Player</option>
                                            
                                        </select>
                                    </div>

                                    
                                    <!-- <div class="form-group" id="multiplayer-field_div">
                                        <label for="exampleFormControlSelect2">Schedule</label >
                                        <input type="datetime-local" class="form-control" id="game_time" name="game_time" value="{{$game->game_time}}"">
                                    </div> -->

                                    <div class="form-group" id="multiplayer-field_div">
                                        <label for="exampleFormControlSelect2">Schedule Date</label >
                                        <input type="date" name="schedule_date" id="schedule_date" value="{{$game->schedule_date}}" class="form-control">

                                        <label for="">Schedule time </label>
                                     <input type="time" name="schedule_time" id="schedule_time" value="{{$game->schedule_time}}" class="form-control">
                                    </div>


                                    <div class="form-group">
                                        <label for="exampleFormControlSelect3">Game Level</label>
                                        <select class="form-control" id="level" name="level">
                                            <option @if($game->level == "Easy") selected @endif>Easy</option>
                                            <option @if($game->level == "Medium") selected @endif>Medium</option>
                                            <option @if($game->level == "Hard") selected @endif>Hard</option>
                                        </select>
                                    </div>

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

<!-- 
                                    <div class="form-group">
                                      <label for="gametag">Game Tag</label>
                                      <select class="form-control" name="tag" id="tag">
                                        @foreach($tags as $tag)
                                        <option value="{{$tag->id}}" @if($game_tag_name == "$tag->name") selected @endif>{{$tag->name}}</option>
                                        @endforeach
                                      </select>
                                    </div> -->

                                    <div class="form-group">
                                      <label for="publish game">Publish Game</label>
                                      <select class="form-control" name="published" id="published">
                                        <option value="1" @if($game->published == "1") selected @endif>Yes</option>
                                        <option value="2" @if($game->published == "0") selected @endif>No</option>
                                      </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="exampleInput9">Host</label>
                                        <select class="form-control" name="host" id="host" required>
                                        @foreach($hosts as $host)
                                        <option value="{{$host->id}}"  @if($host_name == $host->name) selected @endif>{{$host->name}}</option>
                                        @endforeach
                                        
                                        </select>
                                    </div>

                                </div> <input type="button" name="next" class="next action-button" value="Next Step" id="next-1"  />
                            </fieldset>
                            <fieldset>
                                <div class="form-card">
                                    <!-- <h2 class="fs-title">Personal Information</h2>    -->
                                  

                                    <div class="form-group">
                                        <label for="exampleFormControlTextarea1">Host Video Snippet</label>
                                        <textarea class="form-control" id="host_video_snippet" name="host_video_snippet" rows="3">{{$game->host_video_snippet}} </textarea>
                                    </div>

                                    <div class="form-group">
                                        <label for="exampleFormControlSelect5">Game Featured Image</label>
                                        <input type="file" class="form-control-file"  id="game_featured_image-edit" name="game_image" accept="images/*">
                                    </div>
                                
                                    <div class="form-group">
                                        <img src="{{$game->game_image}}" alt="game image" width="100px" height="100px">
                                    </div>


                                    <div class="form-group">
                                        <label for="exampleFormControlSelect6">High Performance Message</label>
                                        <input type="text" class="form-control" id="high_perf_message"  name="high_perf_message" value="{{$game->high_perf_message}}">
                                    </div>

                                    <div class="form-group">
                                        <label for="exampleFormControlSelect6">Low Performance Message</label>
                                        <input type="text" class="form-control" id="low_perf_message"   name="low_perf_message" value="{{$game->low_perf_message}}">
                                    </div>

                                    <div class="form-group">
                                        <label for="exampleFormControlSelect7">Trophy</label>
                                        <select class="form-control" id="exampleFormControlSelect7" name="trophy" id="trophy">
                                            @foreach($all_trophies as $trophies)
                                            <option value={{$trophies->id}} @if($trophy->trophy_name == $trophies->trophy_name) selected @endif>{{$trophies->trophy_name}}</option>
                                            @endforeach

                                            <!-- <option @if($game->trophy == "Trophy 1") selected @endif>Trophy 1</option>
                                            <option @if($game->trophy == "Trophy 2") selected @endif>Trophy 2</option>
                                            <option @if($game->trophy == "Trophy 3") selected @endif>Trophy 3</option>
                                            <option @if($game->trophy == "Trophy 4") selected @endif>Trophy 4</option>
                                            <option @if($game->trophy == "Trophy 5") selected @endif>Trophy 5</option> -->
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleFormControlSelect8">Music File</label>
                                        <input type="file" class="form-control-file"  id="music_file_edit" name="music_file" accept="audio/*" value="{{$game->music_file}}">

                                        
                                        <audio controls>
                                            <source src="{{$game->music_file}}" type="audio/mpeg">
                                            Your browser does not support the audio element.
                                        </audio>
                                    </div>

                                    <div class="form-group">
                                        <label for="exampleFormControlTextarea1">Video Snippet while times run down</label>
                                        <textarea class="form-control" id="time_down_video_snippet" name="time_down_video_snippet" rows="3" >{{$game->time_down_video_snippet}}</textarea>
                                    </div>

                                </div>
                                
                                <input type="button" name="previous" class="previous action-button-previous" value="Previous" /> <input type="button" name="next" class="next action-button" value="Next Step" id="next-btn-2"/>
                            </fieldset>
                            <fieldset>
                                <div class="form-card">
                                <h4 class="fs-title">Round 1 </h4>   
                              

                                <div class="form-group">
                                <label for="exampleFormControlTextarea1">Round 1 Starting Video </label>
                                        <textarea class="form-control"  rows="3" name="round1_starting_video_snippet" id="round1_starting_video_snippet">{{$game->round1_starting_video_snippet}}</textarea>

                                        <label for="exampleFormControlSelect5">Question</label>
                                        <div class="form-group">
                                            <div class="select2-purple">
                                                <select class="select2" multiple="multiple" data-placeholder="Select qustions" data-dropdown-css-class="select2-purple" style="width: 100%;" id="round-1-select-tag" name="round_1_questions[]">
                                                </select>
                                            </div>
                                      
                                        </div>
                                    


                                        <!-- <label for="exampleFormControlTextarea1">Video Snippet</label>
                                        <textarea class="form-control" id="round_1_host_video_snippet" rows="3" name="round_1_host_video_snippet">{{$game->round_1_host_video_snippet}}</textarea> -->
                                    </div>

                                 

                                    <h4 class="fs-title">Round 2 </h4>  



                                    <div class="form-group">
                                    <label for="exampleFormControlTextarea1">Round 2 Starting Video </label>
                                        <textarea class="form-control"  rows="3" id="round2_starting_video_snippet" name="round2_starting_video_snippet" >{{$game->round2_starting_video_snippet}}</textarea>
                                        <label for="exampleFormControlSelect5">Question</label>
                                        <div class="form-group">
                                            <div class="select2-purple">
                                                <select class="select2" multiple="multiple" data-placeholder="Select qustions" data-dropdown-css-class="select2-purple" style="width: 100%;" id="round-2-select-tag" name="round_2_questions[]">
                                                </select>
                                            </div>
                                      
                                        </div>
                                    </div>

                                    <!-- <div class="form-group">
                                        <label for="exampleFormControlTextarea1">Video Snippet</label>
                                        <textarea class="form-control" id="round_2_host_video_snippet" rows="3" name="round_2_host_video_snippet">{{$game->round_2_host_video_snippet}}</textarea>
                                    </div> -->


                                    <h2 class="fs-title">Round 3</h2>
                                    <label for="exampleFormControlTextarea1">Round 3 Starting Video </label>
                                        <textarea class="form-control"  rows="3" name="round3_starting_video_snippet" id="round3_starting_video_snippet">{{$game->round3_starting_video_snippet}}</textarea>
                                   
                                    <div class="form-group">
                                        <label for="exampleFormControlSelect6">Question</label>
                                        <div class="form-group">
                                            <div class="select2-purple">
                                                <select class="select2" multiple="multiple" data-placeholder="Select qustions" data-dropdown-css-class="select2-purple" style="width: 100%;" id="round-3-select-tag" name="round_3_questions[]">
                                                </select>
                                            </div>
                                      
                                    </div>

                                        <!-- <div class="form-group">
                                            <label for="exampleFormControlTextarea1">Video Snippet</label>
                                            <textarea class="form-control" id="round_3_host_video_snippet" rows="3" name="round_3_host_video_snippet">{{$game->round_3_host_video_snippet}}</textarea>
                                        </div> -->
                                    
                                    </div>

                                
                                  

                                   
                                   
                                </div> 
                                
                                <input type="button" name="previous" class="previous action-button-previous" value="Previous" /> <input type="submit"  class="next action-button" value="Update" id="submit-btn" />
                            </fieldset>
                            <fieldset>
                                <div class="form-card">
                                    <h2 class="fs-title text-center">Success !</h2> <br><br>
                                    <div class="row justify-content-center">
                                        <div class="col-3"> <img src="{{asset('assets/images/ok.png')}}" class="fit-image"> </div>
                                    </div> <br><br>
                                    <div class="row justify-content-center">
                                        <div class="col-7 text-center">
                                            <h5>Game has been successfully Updated</h5>
                                        </div>
                                    </div>
                                </div>
                            </fieldset>
                        </form>
                    </div>
                    <div class="col-md-1"></div>
                </div>
            </div>
        </div>
    </div>
</div>
    </section>
    <!-- /.content -->
  </div>


<script>

//if game type is multiplayer hide the field
        if(document.getElementById('gametype').value == 'Multi Player'){
            $('#multiplayer-field_div').show();
        }else{
            $('#multiplayer-field_div').hide();
        }
   
  function multiplayerCheck() {
        if (document.getElementById('gametype').value == 'Multi Player') {
            document.getElementById('multiplayer-field_div').style.display = 'block';
        } else {
            document.getElementById('multiplayer-field_div').style.display = 'none';
        }
    }
    $('.select2').select2()

    //Initialize Select2 Elements
    $('.select2bs4').select2({
      theme: 'bootstrap4'
    })



//store blade variable $$tag_name_array in javascript object
var tag_name_object = [];
tag_name_object   = @json($tag_name_array);

//get name from the tag_name_object 
var tag_name_array = [];
var tag_id_array = [];
for(var i=0; i<tag_name_object.length; i++){
  tag_name_array.push(tag_name_object[i].name);
  tag_id_array.push(tag_name_object[i].id);
}

var tag_select = $('#tag');
//check if tag_select option matches tag_array option and select it
for(var i = 0; i < tag_id_array.length; i++){
  tag_select.find('option').each(function(){
    if($(this).val() == tag_id_array[i]){
      $(this).attr('selected', 'selected');
      $(this).prop('selected', true);
      $(this).parent().trigger('change');
    }
  });
}


var questions = [];
var questions = <?php echo json_encode($questions); ?>

var all_questions = [];
var selected_questions = [];
questions.forEach(element => {
    all_questions.push(element.question);
    //insert all questions in select tag

});
console.log(all_questions);
for(var i=0; i<all_questions.length; i++){
    $('#round-1-select-tag').append('<option value="'+all_questions[i]+'">'+all_questions[i]+'</option>');
    $('#round-2-select-tag').append('<option value="'+all_questions[i]+'">'+all_questions[i]+'</option>');
    $('#round-3-select-tag').append('<option value="'+all_questions[i]+'">'+all_questions[i]+'</option>');

}
//on change of round-1-select-tag get the selected questions and store in selected_questions array
var all_selected_questions = [];
var non_selected_questions = [];
//onchnage of roiund 1 select tag

$('#round-1-select-tag').on('change', function(){
    //get all selected questions of round 2 select tag
    round_2_selected_questions = $('#round-2-select-tag').val();
    round_3_selected_questions = $('#round-3-select-tag').val();
    // make all_selected_questions to be selected options of round 2 select tag
    $('#round-2-select-tag').find('option').each(function(){
        if(round_2_selected_questions.includes($(this).val())){
            $(this).attr('selected', 'selected');
        }
    });
    // make all_selected_questions to be selected options of round 3 select tag
    $('#round-3-select-tag').find('option').each(function(){
        if(round_3_selected_questions.includes($(this).val())){
            $(this).attr('selected', 'selected');
        }
    });
    

    //make all_selected_questions selected in round 2 select tag
    console.log('round_2_selected_questions', round_2_selected_questions);


    selected_questions = [];
    all_selected_questions = [];
    non_selected_questions = [];
    selected_questions = $('#round-1-select-tag').val();

    all_questions.forEach(element => {
        if(selected_questions.includes(element)){
            all_selected_questions.push(element);
        }else{
            non_selected_questions.push(element);
        }
    });
    console.log('all_selected_questions', all_selected_questions);
    console.log('non_selected_questions', non_selected_questions);
    $('#round-2-select-tag').empty();
    $('#round-3-select-tag').empty();
    for(var i=0; i<non_selected_questions.length; i++){
        $('#round-2-select-tag').append('<option value="'+non_selected_questions[i]+'">'+non_selected_questions[i]+'</option>');
        $('#round-3-select-tag').append('<option value="'+non_selected_questions[i]+'">'+non_selected_questions[i]+'</option>');
    }
    //make all_selected_questions selected in round 2 select tag
    console.log('round_2_selected_questions', round_2_selected_questions);
    $('#round-2-select-tag').val(round_2_selected_questions);
    $('#round-3-select-tag').val(round_3_selected_questions);


});

//onchnage of roiund 2 select tag
$('#round-2-select-tag').on('change', function(){
    round_3_selected_questions = $('#round-3-select-tag').val();
    $('#round-3-select-tag').find('option').each(function(){
        if(round_3_selected_questions.includes($(this).val())){
            $(this).attr('selected', 'selected');
        }
    });

    selected_questions = [];
    all_selected_questions = [];
    non_selected_questions = [];

    round1_selected_questions = $('#round-1-select-tag').val();
    round2_selected_questions = $('#round-2-select-tag').val();

        //push round1_selected_questions and round2_selected_questions in all_selected_questions and push non selected questions in non_selected_questions
        round1_selected_questions.forEach(element => {
            all_selected_questions.push(element);
        });
        round2_selected_questions.forEach(element => {
            all_selected_questions.push(element);
        });
        all_questions.forEach(element => {
            if(!all_selected_questions.includes(element)){
                non_selected_questions.push(element);
            }
        });

        $('#round-3-select-tag').empty();
        for(var i=0; i<non_selected_questions.length; i++){
            $('#round-3-select-tag').append('<option value="'+non_selected_questions[i]+'">'+non_selected_questions[i]+'</option>');
        }
        $('#round-3-select-tag').val(round_3_selected_questions);
        

      

});

//onchnage of roiund 3 select tag
$('#round-3-select-tag').on('change', function(){
    //remove selected question in round 3 select tag from round 1 select tag and round 2 select tag
    round1_selected_questions = $('#round-1-select-tag').val();
    round2_selected_questions = $('#round-2-select-tag').val();
    round3_selected_questions = $('#round-3-select-tag').val();
    console.log('round3_selected_questions', round3_selected_questions);
    console.log('round1_selected_questions', round1_selected_questions);
    console.log('round2_selected_questions', round2_selected_questions);
    $('#round-1-select-tag').find('option').each(function(){
        if(round3_selected_questions.includes($(this).val())){
            //remove that option from round 1 select tag
            $(this).remove();
        }

    });
    $('#round-2-select-tag').find('option').each(function(){
        if(round3_selected_questions.includes($(this).val())){
            //remove that option from round 2 select tag
            $(this).remove();
        }
    });
    

});


var round_1_questions = @json($round_1_questions_id);
for(var i=0; i<round_1_questions.length; i++){
    var round_1_question_array = document.getElementById('round-1-select-tag');
    for (var j = 0; j < round_1_question_array.length; j++) {
        if(round_1_question_array[j].value == round_1_questions[i]){
            round_1_question_array[j].selected = true;
        }
    }
}

var round_2_questions = @json($round_2_questions_id);
for(var i=0; i<round_2_questions.length; i++){
    var round_2_question_array = document.getElementById('round-2-select-tag');
    for (var j = 0; j < round_2_question_array.length; j++) {
        if(round_2_question_array[j].value == round_2_questions[i]){
            round_2_question_array[j].selected = true;
        }
    }
}

var round_3_questions = @json($round_3_questions_id);
for(var i=0; i<round_3_questions.length; i++){
    var round_3_question_array = document.getElementById('round-3-select-tag');
    for (var j = 0; j < round_3_question_array.length; j++) {
        if(round_3_question_array[j].value == round_3_questions[i]){
            round_3_question_array[j].selected = true;
        }
    }
}

    

</script>


@endsection