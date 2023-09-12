@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header font-weight-bold">{{ __('Create Task') }}</div>

                <div class="card-body">
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif
                    <form class=" needs-validation" role="form" method="post" action="{{ route('tasks.store')}}" accept-charset="UTF-8" novalidate>
                        @csrf
                        <div class="form-group">
                            <label>title</label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" name="title" id="title" required>
                            @error('title')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Description</label>
                            <textarea type="text" class="form-control @error('description') is-invalid @enderror" name="description" id="description" required></textarea>
                            @error('description')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="col-12">
                            <button class="btn btn-primary float-right" type="submit">Create Task</button>
                            <a href="/home" class="btn btn-secondary float-left">Cancel</a>
                        </div>
                    </form>


                </div>
            </div>
        </div>
    </div>
</div>

@endsection