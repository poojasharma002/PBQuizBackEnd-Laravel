$(document).ready( function () {
    $('#table_id').DataTable();
  } );


$(document).ready(function(){

var current_fs, next_fs, previous_fs; //fieldsets
var opacity;

$(".next").click(function(){
//check if fields are not empty
if($("#gamename").val() == ""){
  swal("Please enter a game name", "", "error");
  return false;
}
//check if multi-player is selected in gametype field
if($("#gametype").val() == "Multi Player"){
  if($("#schedule_date").val() == ""){
    swal("Please select a date", "", "error");
    return false;
  }
  if($("#schedule_time").val() == ""){
    swal("Please select a time", "", "error");
    return false;
  }
}
if($("#tag").val() == ""){
  swal("Please select one game tag", "", "error");
  return false;
}



// if next-btn-2 is clicked
if($(this).attr('id') == "next-btn-2"){
  //check if fields are not empty
  if($("#host_video_snippet").val() == ""){
    swal("Please enter Host Video Snippet", "", "error");
    return false;
  }
  //check if game_featured_image is uploaded in the input file field
  if($("#game_featured_image").val() == ""){
    swal("Please upload Game Featured Image", "", "error");
    return false;
  }
  // check if high_perf_message is not empty
  if($("#high_perf_message").val() == ""){
    swal("High Performance Message is required", "", "error");
    return false;
  }
  if($("#low_perf_message").val() == ""){
    swal("Low Performance Message is required", "", "error");
    return false;
  }
  if($("#music_file").val() == ""){
    swal("Please upload Music File", "", "error");
    return false;
  }
  if($("#time_down_video_snippet").val() == ""){
    swal("Please enter Time Down video snippet", "", "error");
    return false;
  }

}

//if submit is clicked
if($(this).attr('id') == "submit-btn"){
  //check if fields are not empty
  if($("#round1_starting_video_snippet").val() == ""){
    swal("Please enter Round 1 Starting Video Snippet", "", "error");
    return false;
  }
  if($("#round-1-select-tag").val() == ""){
    swal("Please select round 1 questions", "", "error");
    return false;
  }
  // if($("#round_1_host_video_snippet").val() == ""){
  //   swal("Please enter Round 1 Video Snippet", "", "error");
  //   return false;
  // }

  if($("#round2_starting_video_snippet").val() == ""){
    swal("Please enter Round 2 Starting Video Snippet", "", "error");
    return false;
  }
  if($("#round-2-select-tag").val() == ""){
    swal("Please select round 2 questions", "", "error");
    return false;
  }
  // if($("#round_2_host_video_snippet").val() == ""){
  //   swal("Please enter Round 2 Video Snippet", "", "error");
  //   return false;
  // }
  if($("#round3_starting_video_snippet").val() == ""){
    swal("Please enter Round 3 Starting Video Snippet", "", "error");
    return false;
  }
  if($("#round-3-select-tag").val() == ""){
    swal("Please select round 3 questions", "", "error");
    return false;
  }
  // if($("#round_3_host_video_snippet").val() == ""){
  //   swal("Please enter Round 3 Video Snippet", "", "error");
  //   return false;
  // }
  //check if game_featured_image is uploaded in the input file field
}


current_fs = $(this).parent();
next_fs = $(this).parent().next();

//Add Class Active
$("#progressbar li").eq($("fieldset").index(next_fs)).addClass("active");

//show the next fieldset
next_fs.show();
//hide the current fieldset with style
current_fs.animate({opacity: 0}, {
step: function(now) {
// for making fielset appear animation
opacity = 1 - now;

current_fs.css({
'display': 'none',
'position': 'relative'
});
next_fs.css({'opacity': opacity});
},
duration: 600
});
});

$(".previous").click(function(){

current_fs = $(this).parent();
previous_fs = $(this).parent().prev();

//Remove class active
$("#progressbar li").eq($("fieldset").index(current_fs)).removeClass("active");

//show the previous fieldset
previous_fs.show();

//hide the current fieldset with style
current_fs.animate({opacity: 0}, {
step: function(now) {
// for making fielset appear animation
opacity = 1 - now;

current_fs.css({
'display': 'none',
'position': 'relative'
});
previous_fs.css({'opacity': opacity});
},
duration: 600
});
});

$('.radio-group .radio').click(function(){
$(this).parent().find('.radio').removeClass('selected');
$(this).addClass('selected');
});

$(".submit").click(function(){
return false;
})

});
