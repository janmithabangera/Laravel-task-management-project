@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Tasks') }} <a class="btn btn-primary  float-right" href="{{url('/tasks/create')}}" role="button">Create Task</a></div>
                <div class="card-body">
                    @if (session('message'))
                    <div class="alert alert-success" role="alert">
                        {{ session('message') }}
                    </div>
                    @endif


                    <ul class="list-group tasks" id="sortable">
                        <li class="list-group-item active">
                            <div class="row">
                                <div class="col">Title</div>
                                <div class="col">Description</div>
                                <div class="col-auto">Task Priority</div>
                                <div class="col-auto">Status</div>
                                <div class="col-auto">Action</div>
                            </div>
                        </li>
                        @if($tasks->count()>0)
                        @foreach( $tasks as $task )
                        <li class="list-group-item" draggable="TRUE" data-task-id="{{ $task->id }}">
                            <div class="row">
                                <div class="col">{{ $task->title }}</div>
                                <div class="col">{{ $task->description }}</div>
                                <div class="col-auto">{{ $task->priority }}</div>
                                @if ($task->status!="COMPLETED")

                                <div class="col-auto"><a href="/tasks/{{$task->id}}/complete" class="btn btn-warning btn-sm ml-2 float-right">Complete</a>
                                </div>
                                @else
                                <div class="col-auto">{{$task->status}}</div>
                                @endif
                                <div class="col-auto"><a href="/tasks/{{$task->id}}" class="btn btn-primary btn-sm float-right">View</a></div>
                            </div>
                        </li>
                        @endforeach
                        @else
                        <li class="list-group-item text-center">
                            No Tasks Found.
                        </li>
                        @endif
                    </ul>

                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        $("#sortable").sortable({
            stop: function(event, ui) {
                var $e = $(ui.item);
                var $prevItem = $e.prev();
                var $nextItem = $e.next();

                $.ajax({
                    url: "{{ route('tasks.resetPriority') }}",
                    method: 'POST',
                    dataType: 'json',
                    data: {
                        _token: '{{ csrf_token() }}',
                        task_id: $e.data('task-id'),
                        prev_id: $prevItem ? $prevItem.data('task-id') : null,
                        next_id: $nextItem ? $nextItem.data('task-id') : null

                    },
                    success: function(response) {
                        location.reload();
                    },
                });
            }
        });

        $(".alert").delay(5000).slideUp(300);
    });
</script>
@endsection