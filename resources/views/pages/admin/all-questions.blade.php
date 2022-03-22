@extends('layout.layout')
@section('title', 'All Question')

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
              <li class="breadcrumb-item active">All Questions</li>
            </ol>
   
          </div><!-- /.col -->
    
        </div><!-- /.row -->

        <span class="m-0" style="font-size:2rem">All Questions</span>  
        <span class=" float-sm-right">  <a href="{{url('add_question')}}" class="py-3 btn btn-primary mt-3 float-right"><i class="fa fa-plus" aria-hidden="true"></i> Add question</a></span>
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

@if(session('success'))

<div class="px-5">
<div class="alert alert-success my-3 px-5 alert-dismissible fade show" role="alert">
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true" class="text-white" style="color:#fff">&times;</span>
    <span class="sr-only">Close</span>
  </button>
  <strong>{{session('success')}}</strong> 
</div>
</div>

@endif



    <!-- Main content -->
    <section class="content mt-5">
      <div class="container-fluid">
        <div class="row">
          <!-- left column -->
          <div class="col-md-12" style="overflow-x : auto;">
          <table class="table table-bordered" id="all-questions-table">
                <thead>
                    <tr>
                        <th >S.No</th>
                        <th>Question</th>
                        <th>Option One</th>
                        <th>Option Two</th>
                        <th>Option Three</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($questions as $question)
                    <tr>
                        <td style="width:5%">{{$loop->iteration}}</td>
                        <td>{{$question->question}}</td>
                        <td>{{$question->option_one}}</td>
                        <td>{{$question->option_two}}</td>
                        <td>{{$question->option_three}}</td>
                        <td style="width:10%">
                            <a href="{{route('edit-question',$question->id)}}" class="btn btn-primary"><i class="fa fa-edit" aria-hidden="true"></i> </a>
                            <a href="javascript:void(0)" class="btn btn-danger text-light deleteBtn" onclick="deleteFunc(this,{{$question->id}})"> <i class="fa fa-trash" aria-hidden="true"></i> </a></td>
                        </td>
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


  <script>

    function deleteFunc(this_para,id){
      var id = id;
   swal({
          title: "Are you sure you want to delete question?",
          icon: "warning",
          buttons: true,
          dangerMode: true,
        })
        .then((willDelete) => {
          if (willDelete) {
                $.ajax({
                type:"post",
                url: "{{ url('delete/question') }}",
                data: { _token: "{{csrf_token()}}" , id: id },
                dataType: 'json',
                    success: function(res){
                            $(this_para).closest('tr').remove();
                            swal("Question deleted successfully", {
                              icon: "success",
                            });
                    }
                }); 
          }
        });
    }



    // add data table 
    $(document).ready(function() {
    $('#all-questions-table').DataTable({
      // "sScrollX": '100%'
    });
    } 
    );

</script>


@endsection