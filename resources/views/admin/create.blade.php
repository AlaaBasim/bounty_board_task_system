@extends('/layouts.app')

@section('content')
        <h1>Create</h1>
        
        <form method="post" action="{{route('task.store')}}">
            @csrf
            <div class="form-group">
                <label for="title">Title</label>
                <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" id="title" area-describedby="" placeholder="Enter Title"> 

                @error('title')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="form-group">
                <label for="description">description</label>
                <input type="text" name="description" class="form-control-file @error('description') is-invalid @enderror" id="description" area-describedby=""> 
                @error('description')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="form-group">
                <label for="">Choose Category</label>
                <select name="department_id" class="form-control @error('department_id') is-invalid @enderror"  required="">
                    <option value="">select</option>
                    @foreach(App\Models\Department::all() as $department)
                    <option value="{{$department->id}}"
                        >{{$department->name}}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="assets">Assets</label>
                <input type="text" name="assets" class="form-control @error('assets') is-invalid @enderror" id="assets" area-describedby="" placeholder="Enter Assets URL"> 
                @error('assets')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="form-group">
                <label for="resources">Resources</label>
                <input type="text" name="resources" class="form-control @error('resources') is-invalid @enderror" id="resources" area-describedby="" placeholder="Enter Resources URL"> 
                @error('resources')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="form-group">
                <label for="start_date">Start Date</label>
                <input type="date" name="start_date" class="form-control @error('start_date') is-invalid @enderror" id="start_date" area-describedby="" placeholder="Enter Start Date">
                @error('start_date')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror 
            </div>

            <div class="form-group">
                <label for="deadline">Deadline</label>
                <input type="date" name="deadline" class="form-control @error('deadline') is-invalid @enderror" id="deadline" area-describedby="" placeholder="Enter Deadline Date"> 
                @error('deadline')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="form-group">
                <label for="budget">budget</label>
                <input type="number" name="budget" class="form-control @error('budget') is-invalid @enderror" id="budget" area-describedby="" placeholder="Enter Budget Amount"> 
                @error('budget')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div id="target">
                <label for="requirements">Requirements</label>
                <a href="#" class="addReq btn btn-primary" onclick="addReq()">+</a>

                <input type="text" name="requirements[]" class="form-control @error('requirements') is-invalid @enderror" id="requirements" placeholder="Enter requirment "> 
                @error('requirements')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        
            <div class="form-group">
                <input type="submit" class="btn btn-primary">
            </div>

        </form>
@endsection

<script type="text/javascript">
    function addReq(){  
        var req = '<input type="text" name="requirements[]" class="form-control" id="requirements" placeholder="Enter requirment ">';
        document.getElementById('target').innerHTML += req;
    }
</script>