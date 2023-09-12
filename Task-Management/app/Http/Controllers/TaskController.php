<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;
use Illuminate\Support\Facades\Route;

class TaskController extends Controller
{
    public function index()
    {
        //
    }

    public function show(Request $request)
    {
        $taskId = $request->route('task');
        $task = Task::where('user_id', Auth::user()->id)->where('id', $taskId)->first();
        if (isset($task)) {
            return view('tasks/show')->with('task', $task);
        }
        return redirect()->back();
    }
    public function create()
    {
        return view('Tasks/create');
    }
    public function store(Request $request)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'title' => 'required',
            'description' => 'required'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors());
        }

        $lastTask = Task::where('user_id', Auth::user()->id)->orderBy('priority', 'desc')->first();

        $task = new Task();
        $task->title = $request->title;
        $task->description =  $request->description;
        $task->priority = isset($lastTask) ? $lastTask->priority + 1 : 1;
        $task->status = "PENDING";
        $task->user_id = Auth::user()->id;

        $task->save();

        session()->flash('message', 'Task Created Successfully!');

        return redirect('/home');
    }
    public function edit(Request $request)
    {
        $taskId = $request->route('task');
        $task = Task::where('user_id', Auth::user()->id)->where('id', $taskId)->first();

        if (isset($task)) {
            return view('tasks/edit')->with('task', $task);
        }
        return redirect()->back();
    }
    public function update(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'title' => 'required',
            'description' => 'required'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors());
        }

        $taskId = $request->route('task');
        $task = Task::where('user_id', Auth::user()->id)->where('id', $taskId)->first();
        $task->title = $request->title;
        $task->description =  $request->description;
        $task->save();

        session()->flash('message', 'Task Updated Successfully!');

        return redirect('/home');
    }

    public function destroy(Request $request)
    {
        $taskId = $request->route('task');
        $userID= Auth::user()->id;
        $taskToBeDelete = Task::where('user_id',$userID)->where('id', $taskId)->first();
        $resetPriorityTasks = Task::where('user_id', $userID)->where('priority', '>', $taskToBeDelete->priority)->get();

        foreach ($resetPriorityTasks as $task) {
            $task->priority = $task->priority - 1;
            $task->save();
        }
        $taskToBeDelete->delete();
        session()->flash('message', 'Task Deleted Successfully!');

        return redirect('/home');
    }


    public function completeTask(Request $request)
    {
        $task = Task::where('user_id', Auth::user()->id)->where('id', $request->route('taskId'))->first();
        if (isset($task)) {
            $task->status = "COMPLETED";
            $task->save();

            session()->flash('message', 'Task Completed Successfully!');
        }

        return redirect('/home');
    }

    public function resetTaskPriority(Request $request)
    {
        $task = Task::findOrFail($request->input('task_id'));
        $prev = Task::find($request->input('prev_id'));

        if (!$request->input('prev_id')) {
            $destination = 1;
        } else if (!$request->input('next_id')) {
            $destination = Task::where('user_id', Auth::user()->id)->count();
        } else {
            $destination = $task->priority < $prev->priority ? $prev->priority : $prev->priority + 1;
        }

        Task::where('user_id', Auth::user()->id)->where('priority', '>', $task->priority)
            ->where('priority', '<=', $destination)
            ->update(['priority' => \DB::raw('priority - 1')]);

        Task::where('user_id', Auth::user()->id)->where('priority', '<', $task->priority)
            ->where('priority', '>=', $destination)
            ->update(['priority' => \DB::raw('priority + 1')]);

        $task->priority = $destination;
        $task->save();

        return response()->json(true);
    }
}
