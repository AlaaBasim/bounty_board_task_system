@extends('/layouts.app')

@section('content')

<h3>Tasks For My Department</h3>
<br>
<a href="{{route('tasks.history')}}" class="btn btn-primary mb-4"> View My Tasks</a>

@if(Session::has('message'))
<div class="alert alert-primary"> {{Session::get('message')}}</div>
@endif

<div class="row"> 
    @foreach($tasks as $task)
    <div class="col-md-4">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Task Title: {{$task->title}}</h5>
                <p class="card-text">Task Description: {{$task->description}}</p>
                <br>                

                <a href="#" class="btn btn-primary">Assets</a>
                <a href="#" class="btn btn-primary">Resources</a>

                <br>
                <br>
                <p>Start Date: {{$task->start_date}}</p>
                <p>Deadline: {{$task->deadline}}</p>

                <br>

                <h5>Budget: {{$task->budget}}$</h5>

                <a href="{{route('task.view', $task->id)}}" class="btn btn-primary">VIEW TASK</a>

            </div>
        </div>
    </div>
    @endforeach
</div>
@endsection