<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\TaskCollection;
use App\Http\Resources\TaskResource;
use App\Models\Task;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Request as RequestFacade;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $tasks = Task::latest()->get();
        return response()->json(['status_code'=>200, 'status'=>'success', 'data' => new TaskCollection($tasks)], 200);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //

        $request->validate([
            'task_name' => 'required',
            'description' => 'required',
            "start_date"  => "required",
            'end_date' => 'required',
            'status' => 'required',
        ]);

        $task = Task::create([
            'task_name'=>$request->get('task_name'),
            'description'=> $request->get('description'),
            'start_date' => $request->get('start_date'), //To save an array of authors in the database
            'end_date' => $request->get('end_date'),
            'status' => $request->status,

        ]);
        return response()->json(['status_code'=>201, 'status'=>'success', 'data' => new TaskResource($task)], 201);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        try{
            $task = Task::findOrFail($id);
            return response()->json(['status_code'=>200, 'status'=>'success', 'data' => new TaskResource($task)], 200);
        }
        catch(ModelNotFoundException $err){
            return response()->json(['status_code'=>404, 'status'=>'error', "message" => "The requested task was not found"], 404);
        }

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        try{
            $task = Task::findOrFail($id);

            return response()->json(new TaskResource($task), 200);

        }
        catch(ModelNotFoundException $err){
            return response()->json(["status_code"=> 404, 'status'=>'error', "message" => "The requested task was not found"], 404);
        }
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
        //
        $request->validate([
            'task_name' => 'required',
            'description' => 'required',
            "start_date"  => "required",
            'end_date' => 'required',
            'status' => 'required',
        ]);
        try{
            //Find the user object from model if it exists
            $task= Task::findOrFail($id);

            $task->update([
                'task_name'=>$request->get('task_name'),
                'description'=> $request->get('description'),
                'start_date' => $request->get('start_date'), //To save an array of authors in the database
                'end_date' => $request->get('end_date'),
                'status' => $request->status,

            ]);

            return response()->json(["status_code" => 200, 'status'=>'success', "message" => 'The task ' . $task->name . ' was updated successfully', 'data' => new TaskResource($task)], 200);
        }
        catch(ModelNotFoundException $err){
            return response()->json(["status_code" => 404,'status'=>'error', "message" => "The requested book was not found"], 404);
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        try{
            $task= Task::findOrFail($id);
            $deleteTask = $task->delete();
            return response()->json(["status_code" => 204, 'status'=>'success', "message" => 'The task ' . $task->name . ' was deleted successfully', 'data' => $deleteTask], 204);
        }
        catch(ModelNotFoundException $err){
            return response()->json(["status_code" => 404, 'status'=>'error', "message" => "The requested task was not found"], 404);
        }
    }

    public function search(Request $request){
        $q = $request->get( 'query' );
        $books = Task::where ( 'task_name', 'LIKE', '%' . $q . '%' )
                    ->orWhere ( 'description', 'LIKE', '%' . $q . '%' )
                    ->orWhere ( 'start_date', 'LIKE', '%' . $q . '%' )
                    ->orWhere ( 'end_date', 'LIKE', '%' . $q . '%' )->get();

        if(count($books) > 0){
            return response()->json(['status_code' => '200', 'status'=>'success', 'data'=>$books], 200);
        }
        else{
            return response()->json(['status_code' => '404', 'status'=>'success', 'message'=>"No Book is Found"], 404);
        }

    }
}