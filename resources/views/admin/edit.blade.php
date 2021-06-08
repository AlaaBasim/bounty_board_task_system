@extends('/layouts.app')

@section('content')
        <h1>Edit</h1>

        <form method="post" action="{{route('task.update', $task_details->id)}}">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="title">Title</label>
                <input type="text" name="title" class="form-control" id="title" area-describedby="" placeholder="Enter Title" value="{{$task_details->title}}"> 
            </div>

            <div class="form-group">
                <label for="description">description</label>
                <input type="text" name="description" class="form-control-file" id="description" area-describedby="" value="{{$task_details->description}}"> 
            </div>

            <div class="form-group">
                <label for="">Choose Department</label>
                <select name="department_id" class="form-control @error('department_id') is-invalid @enderror" >
                    <option value="">select</option>
                    @foreach($departments as $department)
                        @if($department->id == $task_details->department_id)
                        <option value="{{$department->id}}"
                            selected>{{$department->name}}</option>
                        @else
                        <option value="{{$department->id}}"
                            >{{$department->name}}</option>
                        @endif
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="assets">Assets</label>
                <input type="text" name="assets" class="form-control" id="assets" area-describedby="" placeholder="Enter Assets URL" 
                value="{{$task_details->assets}}"> 
            </div>

            <div class="form-group">
                <label for="resources">Resources</label>
                <input type="text" name="resources" class="form-control" id="resources" area-describedby="" placeholder="Enter Resources URL"
                 value="{{$task_details->resources}}"> 
            </div>

            <div class="form-group">
                <label for="start_date">Start Date</label>
                <input type="date" name="start_date" class="form-control" id="start_date" area-describedby="" placeholder="Enter Start Date" 
                value="{{$task_details->start_date}}"> 
            </div>

            <div class="form-group">
                <label for="deadline">Deadline</label>
                <input type="date" name="deadline" class="form-control" id="deadline" area-describedby="" placeholder="Enter Deadline Date"
                 value="{{$task_details->deadline}}"> 
            </div>

            <div class="form-group">
                <label for="budget">budget</label>
                <input type="number" name="budget" class="form-control" id="budget" area-describedby="" placeholder="Enter Budget Amount" 
                value="{{$task_details->budget}}"> 
            </div>

          
            <div id="target">
                <label for="requirements">Requirements</label>
                <a href="#" class="addReq btn btn-primary ml-5" onclick="addReq()">+</a>
                @foreach($requirements as $requirement)
                 <input type="text" name="requirements[]" class="form-control mt-2" id="requirements" placeholder="Enter requirment "
                 value="{{$requirement->body}}"> 
                @endforeach
            </div>
        
            <div class="form-group">
                <input type="submit" class="btn btn-primary mt-4">
            </div>

        </form>
        
     </body>
</html>

<script type="text/javascript">
    function addReq(){  
        var req = '<input type="text" name="requirements[]" class="form-control" id="requirements" placeholder="Enter requirment ">';
        document.getElementById('target').innerHTML += req;
    }
</script>