<?php

namespace App\Http\Controllers;

use App\Models\Worker;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class WorkerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Worker::with('department')->get();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator= Validator::make($request->all(),[
            'department_id' => 'required|exists:departments,id',
            'name' => 'required',
            'city' => 'required',
            'email' => 'required|email|unique:workers',

        ]);
        if($validator->fails()){
            return response()->json($validator->errors(), 422);
        };
        
        $worker =  Worker::create($request->all());
        return response()->json($worker, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $worker = Worker::find($id);
        if(!$worker){
            return response()->json(['message' => 'Worker not found'], 404);
        }
        return $worker;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,$id)
    {
        $validator = Validator::make($request->all(),[
            'email' => 'email|unique:workers',
            'department_id' =>'exists:departments_id'
        ]);

        if($validator->fails()){
            return response()->json($validator->errors(), 422);
        };

        $worker = Worker::find($id);
        if (!$worker) {
        return response()->json(['message' => 'Worker not found'], 404);
        }
        $worker->update($request->all());
        return response()->json(['message' => 'Worker updated successfully'], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $worker = Worker::find($id);
        if (!$worker) {
        return response()->json(['message' => 'Worker not found'], 404);
        }
        $worker->delete();
        return response()->json(['message' => 'Worker deleted successfully'], 200);
    }
}
