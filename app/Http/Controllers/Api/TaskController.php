<?php

namespace App\Http\Controllers\Api;
   use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Api\BaseController as BaseController;
use App\Http\Resources\Task as TaskResource;
use App\Models\Task;
use Validator;
use App\Http\Controllers\Controller;

class TaskController extends BaseController
{
    //Task CRUD Actions 
    public function index()
    {
         // paginate the authorized user's tasks with 5 per page
         $tasks = Auth::user()
         ->tasks()
         ->orderBy('is_complete')
         ->orderByDesc('created_at')
         ->paginate(5);

     // return task index view with paginated tasks
    //  return view('tasks', [
    //      'tasks' => $tasks
    //  ]);
        $tasks = Task::all();
        return $this->handleResponse(TaskResource::collection($tasks), 'Tasks have been retrieved!');
    }

    
    public function store(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'name' => 'required',
            'title' => 'required',
            'details' => 'required'
        ]);
        if($validator->fails()){
            return $this->handleError($validator->errors());       
        }
        $tasks = Auth::user();
        $task = Task::create($input);
        return $this->handleResponse(new TaskResource($task), 'Task created!');
    }

   
    public function show($id)
    {
        $task = Task::find($id);
        if (is_null($task)) {
            return $this->handleError('Task not found!');
        }
        return $this->handleResponse(new TaskResource($task), 'Task retrieved.');
    }
    

    public function update(Request $request, Task $task)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'name' => 'required',
            'details' => 'required'
        ]);

        if($validator->fails()){
            return $this->handleError($validator->errors());       
        }

        $task->name = $input['name'];
        $task->details = $input['details'];
        $task->save();
        
        return $this->handleResponse(new TaskResource($task), 'Task successfully updated!');
    }
   
    public function destroy(Task $task)
    {
        $task->delete();
        return $this->handleResponse([], 'Task deleted!');
    }
}
