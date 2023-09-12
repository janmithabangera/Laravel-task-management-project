@extends('layouts/app')

@section('content')
<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-8">
      <div class="card">
        <div class="card-header font-weight-bold">
          {{ __('Show Task') }} > {{$task->title}}

        </div>

        <div class="card-body">
          <p class="card-text">
            {{ $task->description }}
          </p>
          <form action="{{ route('tasks.destroy',$task->id)}}" method="POST">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger float-right mx-1">Delete</button>
          </form>

          <a href="/tasks/{{$task->id}}/edit" class="btn btn-warning ml-2 float-right">Edit</a>
          <a href="/home" class="btn btn-secondary ">Back</a>

        </div>
      </div>
    </div>
  </div>
</div>
@endsection