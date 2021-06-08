@extends('/layouts.app')

@section('content')
<div class="container-fluid">
<table class="table">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Task Title</th>
      <th scope="col">Description</th>
      <th scope="col">Progress</th>
      <th scope="col">Status</th>
      <th scope="col">New Progress(0-1)</th>
      <th scope="col">Delivery Request</th>
    </tr>
  </thead>
  <tbody>

    @php $i=1 @endphp
    @foreach($tasks as $task)
        <tr>
        <th scope="row">{{$i++}}</th>
        <td>{{$task->title}}</td>
        <td> {{$task->description}}</td>
        <td> <p id="progress{{$task->id}}"> {{$task->progress}} </p></td>
        <td>
            @if($task->progress == 1)
            <p>Completed</p>
            @else
            <p id="status{{$task->id}}">In Progress</p>
            @endif
        </td>
        <td>
        <div>
        @csrf
        <input type="number" step=".01" class="newProgress">
         <button class="update" data-task="{{ $task->id }}" >Update Progress</button>
        </div>
        
        
        </td>
        <td>
           <a href="{{route('deliverable.create', [$task->id])}}" id="deliver{{$task->id}}" class="btn btn-primary @if($task->progress != 1) disabled @endif">Make Request</a>
        </td>
        </tr>
    @endforeach



  </tbody>
</table>
</div>
@endsection

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

<script type="text/javascript">
// when the document is ready

    $("document").ready(function(){
      $(".update").click(function(e){
          e.preventDefault();
          var progress = $(".newProgress").val();
          var task_id = $(this).data('task');

          $.ajax({
            headers: {
               'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: "{{route('update.progress')}}",
            type: "PUT",
            data:{
              id : task_id,
              progress: progress,
            },
            success: function(res){
              if(res.bool==true){
                var newValue = res.value;
                $("#progress"+task_id).text(newValue);

                if(res.value == 1){
                  $('#deliver'+task_id).removeClass('disabled');
                  $("#status"+task_id).text('completed');
                }
              } else {
                alert("Error occured");
              }
            },
          });
      });
    });

   
</script>