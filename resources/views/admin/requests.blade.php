@extends('/layouts.app')

@section('content')

<div class="container-fluid">

@if(Session::has('message'))
<div class="alert alert-primary"> {{Session::get('message')}}</div>
@endif

<table class="table">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Task Title</th>
      <th scope="col">Claim Request From</th>
      <th scope="col">Approve</th>
      <th scope="col">Disapprove</th>
    </tr>
  </thead>
  <tbody>

    @php $i=1 @endphp
    @foreach($requested_tasks as $task)
        <tr>
        <th scope="row">{{$i++}}</th>
        <td>{{$task->title}}</td>
        <td>{{$task->name}}</td>
        <td>
        <form action="{{route('claim.responde')}}" method="post"> 
        @csrf
        @method('PUT')
            <input type="hidden" name="user_id" value="{{$task->user_id}}">
            <input type="hidden" name="task_id" value="{{$task->task_id}}">
            <input type="hidden" name="approve" value="1">
            <button class="btn btn-success btn-sm" type="submit">
                Approve
            </button>
        </form>
        </td>
        <td>
        
        <form action="{{route('claim.responde')}}" method="post"> 
        @csrf
        @method('PUT')
            <input type="hidden" name="user_id" value="{{$task->user_id}}">
            <input type="hidden" name="task_id" value="{{$task->task_id}}">
            <input type="hidden" name="approve" value="-1">
            <button class="btn btn-danger btn-sm" type="submit">
                Disapprove
            </button>
        </form>
        </td>
        </tr>
    @endforeach



  </tbody>
</table>
</div>

@endsection