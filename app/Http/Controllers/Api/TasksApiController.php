<?php

namespace App\Http\Controllers\Api;

use App\Task;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\Filter;
use App\Http\Controllers\Controller;
use Spatie\QueryBuilder\QueryBuilder;
use App\Http\Resources\Task as TaskResource;

class TasksApiController extends Controller
{
    public function index()
    {
        // $tasks = Task::with(['project', 'user'])
        //             ->paginate(3);
        $tasks = QueryBuilder::for(Task::class)
                    ->allowedIncludes(['project', 'user'])
                    ->allowedFilters(['completed', 'due_date', Filter::exact('user_id'),Filter::exact('project_id')])
                    ->get();


        return TaskResource::collection($tasks);
    }

    public function show(Task $task)
    {
        return new TaskResource($task->load('user', 'project'));
    }

    public function store()
    {
        request()->validate([
            'body' => 'required',
            'hours' => 'numeric|min:1|max:8'
        ]);
        
        $task = Task::create([
            'user_id' => request('user') ? request('user') : auth()->user()->id,
            'project_id' => request('project'),
            'due_date' => request('due_date'),
            'body' => request('body'),
            'hours' => request('hours'),
        ]);

        return new TaskResource($task->load(['user', 'project']));
    }

    public function patch(Task $task)
    {
        request()->validate([
            'body' => 'sometimes|required',
            'hours' => 'sometimes|numeric|min:1|max:8'
        ]);

        $task->update(request()->all());

        return new TaskResource($task->load(['user', 'project']));
    }
}
