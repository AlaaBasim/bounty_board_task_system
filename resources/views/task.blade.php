@extends('layouts.app')

@section('content')

<div class="card">
  @if(Session::has('message'))
  <div class="alert alert-primary"> {{Session::get('message')}}</div>
  @endif
  <div class="card-body">
    <h5 class="card-title">Task Title: {{$task->title}}</h5>
    <p class="card-text">Task Description: {{$task->description}}</p>
    <br>
    <h5>Requirements</h5>
    
    <ul>
        @foreach($requirments as $req)
        <li>{{$req->body}}</li>
        @endforeach
    </ul>

    <a href="#" class="btn btn-primary">Assets</a>
    <a href="#" class="btn btn-primary">Resources</a>

    <br>
    <br>
    <p>Start Date: {{$task->start_date}}</p>
    <p>Deadline: {{$task->deadline}}</p>

    <br>

    <h5>Budget: {{$task->budget}}$</h5>

  </div>

  <br>

  @if(Auth::user()->is_admin == 0)
      <form action="{{route('task.claim')}}" method="post">
        @csrf  
        @method('PUT')
        <input type="hidden" name="user_id" value="1">
        <input type="hidden" name="task_id" value="{{$task->id}}">
        <button type="submit" class="btn btn-success">Claim Task</button>
      </form>
  @endif

  <br> 

  <div class="card-body">
    <h5 class="card-title">Comments Section</h5>
    <div class="add-comment mb-3">
      @csrf
      <textarea class="form-control comment @error('body') is-invalid @enderror" placeholder="Enter Comment"></textarea>
      @error('body')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
      @enderror
      <button data-task="{{ $task->id }}" class="btn btn-sm btn-outline-primary addComment">Add Comment</button>
    </div>
    <br>

    <div class="comments">
      @if(count($comments)>0)
        @foreach($comments as $comment)
        @php
          $id = $comment->user_id;
          $username = App\Models\User::find($id)->name;
        @endphp
        <blockquote class="blockquote">
          <p>{{$username}}: {{$comment->body}}</p>
        </blockquote>
        @endforeach  
      @else
        <h4>No Comments For This Task</h4>
      @endif
    </div>

  </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

<script type="text/javascript">
// when the document is ready

    $("document").ready(function(){
      $(".addComment").click(function(e){
          e.preventDefault();
          var task_id = $(this).data('task');
          var comment = $(".comment").val();
          var user_id = {!! auth()->user()->id !!};
        
          $.ajax({
            headers: {
               'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: "{{route('add.comment')}}",
            type: "POST",
            data:{
              commentable_id: task_id,
              commentable_type: 'task',
              body: comment,
              user_id: user_id,
            },
            success: function(res){
              var _html='<blockquote class="blockquote animate__animated animate__bounce">\
              <p>' + res.user_name + ": " +res.comment+'</p>\
              </blockquote><hr/>';
              if(res.bool==true){
                  $(".comments").append(_html);
                  $(".comment").val('');
                  $(".comment-count").text($('blockquote').length);
              }
           
            },
          });
      });
    });

   
</script>

@endsection


