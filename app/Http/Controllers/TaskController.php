<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{


    public function all()
    {
        return $task = response()->json(Task::paginate(10));
    }
    public function store(Request $request)
    {

        Task::create($request->all());;
    }


    public function show($id)
    {
        return response()->json(Task::find($id));
    }

    public function update(Request $request, $id)
    {
        $task = Task::find($id);

        $task->name = $request->name;
        $task->body = $request->body;
        $task->save();
    }

    public function delete($id)
    {
        if ($task = Task::find($id)) {
            return  $task->delete();
        }
    }
}
