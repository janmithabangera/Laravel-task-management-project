@extends('layouts/app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card border-primary">
                <div class="card-header font-weight-bold">
                    {{ __('Edit Task') }} > {{$task->title}}

                </div>
                <div class="card-body">
                    <form action="{{ route('tasks.update',$task->id)}}" method="post">
                        @method('PUT')
                        @csrf
                        <div class="form-group">
                            <label>title</label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" name="title" id="title" value="{{$task->title}}" required>
                            @error('title')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Description</label>
                            <textarea type="text" class="form-control @error('description') is-invalid @enderror" name="description" id="description" required>{{$task->description}}</textarea>
                            @error('description')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="form-group text-center">
                            <button class="btn btn-success" type="submit">Update</button>
                            <a href="/tasks/{{$task->id}}" class="btn btn-secondary ">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endsection