<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\TaskResource;
use App\Models\Task;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return TaskResource::collection(Task::orderBy("id")->get());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $task = Task::create([
            "name" => $request->name
        ]);
        $task->checked = false;
        $task->save();
        return new TaskResource($task);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $task = $this->findObject(new Task, $id, "task");
        if ($task["error"]!= "") {
            return response()->json(["error" => $task["error"]], $task["code"]);
        }
        return response()->json(new TaskResource($task),200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if (count($request->all()) != 1) {
            return response()
            ->json(["error" => "Only check field will be updated !"], 400);
        }
        try {
            $task = Task::findOrFail($id);
        }catch (Exception $e){
            return response()
            ->json(["error" => "Not found this Task by given id"],404);
        }
        $task->checked = $request->checked;
        $task->save();
        return response()
        ->json(new TaskResource($task), 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {   
        $task = $this->findObject(new Task, $id, "task");
        if ($task["error"]!= "") {
            return response()->json(["error" => $task["error"]], $task["code"]);
        }
        $task->delete();
        return response()->json([],204);
    }
}
