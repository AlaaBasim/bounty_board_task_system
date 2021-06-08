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
      <th scope="col">Deliverable Title</th>
      <th scope="col">Description</th>
      <th scope="col">Associated User</th>
      <th scope="col">Download File</th>
      <th scope="col">Approve</th>
      <th scope="col">Disapprove</th>
    </tr>
  </thead>
  <tbody>

    @php $i=1 @endphp
    @foreach($deliverables as $deliverable)
        <tr>
        <th scope="row">{{$i++}}</th>
        <td>{{$deliverable->title}}</td>
        <td>{{$deliverable->description}}</td>
        <td>{{$deliverable->user_id}}</td>
        <td><a href="{{route('deliverable.download', $deliverable->id)}}" class="btn btn-primary">Download</a></td>
        <td>
        <form action="{{route('deliverable.responde')}}" method="post"> 
        @csrf
        @method('PUT')
            <input type="hidden" name="id" value="{{$deliverable->id}}">
            <input type="hidden" name="approve" value="1">
            <button class="btn btn-success btn-sm" type="submit">
                Approve
            </button>
        </form>
        </td>
        <td>
        
        <form action="{{route('deliverable.responde')}}" method="post"> 
        @csrf
        @method('PUT')
            <input type="hidden" name="id" value="{{$deliverable->id}}">
            <input type="hidden" name="approve" value="0">
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