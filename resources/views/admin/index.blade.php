@extends('/layouts.app')

@section('content')
<div class="container-fluid">
    @if(Session::has('message'))
    <div class="alert alert-primary"> {{Session::get('message')}}</div>
    @endif
    <a class="btn btn-primary mb-4 mr-4" href="{{route('task.create')}}"> Create Task</a>
    <a class="btn btn-primary mb-4 mr-4" href="{{route('tasks.requested')}}"> Claim Requests</a>
    <a class="btn btn-primary mb-4 mr-4" href="{{route('deliverables.requested')}}"> Delivery Requests</a>
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
                   
                     <a href="{{route('task.view', $task->id)}}" class="btn btn-primary">View Task Details</a>
                     @if(Auth::user()->is_admin == 1)
                     <a href="{{route('task.edit', $task->id)}}" class="btn btn-primary">Review TASK</a>
                    @endif
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>


@endsection