<?php

namespace App\Http\Controllers;

use App\Task;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TaskController extends Controller
{

    public function index(){

        $tasks = Task::orderBy('updated_at','ASC')->get();

        return view('pages.index',compact('tasks'));

    }

    public function store(Request $request){


        $validator = Validator::make( $request->all(),[
            'title' => ['required', 'string'],
            'description' => ['max:500', 'string'],
            'status' => ['in:TO_DO,IN_PROGRESS_DONE'],
            'image' => ['in:TO_DO,IN_PROGRESS_DONE']
        ] );
        if($validator->fails())
            return response()->json(['type' => 'validation_error','messages' => $validator->messages()]);

        $data = [
            'title' => $request->title,
            'description' => $request->description,
            'due_date' => $request->due_date,
        ];

       $task = Task::create($data);

        return response()->json([
            'code' => 200,
            'message' => 'added_successfully',
            'data' => $task
        ]);
    }
    public function delete(Request $request){

        $validator = Validator::make( $request->all(), [
            'id' => ['required','numeric','exists:tasks,id'],

        ] );
        if($validator->fails())
            return response()->json(['type' => 'validation_error','messages' => $validator->messages()]);


        $status = Task::where('id',$request->id)->delete();

        if ($status)

            return response()->json([
                'code' => 200,
                'message' => 'deleted_successfully',
            ]);

        return response()->json([
            'code' => 500,
            'message' => 'Oops something wrong happened',
        ]);
    }


    public function update_status(Request $request){

        $validator = Validator::make( $request->all(), [
            'status' => ['required','in:TO_DO,IN_PROGRESS,DONE'],
            'id' => ['required','numeric','exists:tasks,id'],

        ] );
        if($validator->fails())
            return response()->json(['type' => 'validation_error','messages' => $validator->messages()]);


        if ($request->status == 'DONE')
            $complete_date = Carbon::now();

        $task = Task::where('id', $request->id)->update(['status' => $request->status,'complete_date' => $complete_date]);

        if ($task)
            return response()->json([
                'code' => 200,
                'message' => 'updated_successfully',
            ]);

    }
}
