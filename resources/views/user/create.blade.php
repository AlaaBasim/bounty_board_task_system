@extends('/layouts.app')

@section('content')
<div class="col-lg-10" id="app">
    <form action="{{route('deliverable.store')}}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="card mb-6">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Create Delivery Request</h6>
        </div>
        <div class="card-body">
            <div class="form-group"> 
                <label for="">Title</label>
                <input type="text" name="title" class="form-control @error('title') is-invalid @enderror " id="" aria-describedby=""
                placeholder="Enter Name of Deliverable">
                @error('title')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            
            </div>

            <div class="form-group">
                <label for="">Description</label>
                <textarea name="description" id="" class="form-control @error('description') is-invalid @enderror "></textarea>
                @error('description')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror   
            </div>

            <div class="form-group">
                <div class="custom-file">
                <input type="file" class="custom-file-input @error('file') is-invalid @enderror  " id="customFile" name="file">
                <label class="custom-file-label  " for="customFile">Choose file</label>
                    @error('file')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
                </div>                
            </div>
            <input type="hidden" name="user_id" value="1">
            <button type="submit" class="btn btn-primary">Submit</button>         
        </div>
    </form>
@endsection