<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class UserTaskController extends Controller
{
    //

    public function index(){
        $department_id = auth()->user()->department_id;
        $tasks = DB::table('tasks')->where('department_id', 1)->get(); 
        return view('user.index', compact('tasks'));
    }

    public function taskHistory(){
        $current_user_id = 1;
        $tasks = DB::table('tasks')->where('assigned_user_id', $current_user_id)->get(); 
        return view('user.own_tasks', compact('tasks'));
    }

    public function updateProgress(Request $request){

        $newProgress = $request->progress; 
        try{
            DB::table('tasks')->where('id', $request->id)
            ->update(['progress' => $newProgress]);

            return response()->json([
            'bool' =>true,
            'value'=>$newProgress,
            ]);
        }catch(Exception $e){
            return response()->json([
                'bool' =>false,
                'value'=>$e->getMessage(), 
            ]);
        }
    }

    public function makeClaimRequest(Request $request){
      
        //Security condition to check that department matches
        $user_department = DB::table('users')->where('id', $request->user_id)->get()->first()->department_id;
        $task_department = DB::table('tasks')->where('id', $request->task_id)->get()->first()->department_id;
        if($user_department == $task_department){
            try{
                //If the user already requested the task then display a message and return
                if(DB::table('task_user')->where('task_id', $request->task_id)->where('user_id', $request->user_id)->get()->first() != null){
                    Session::flash('message', 'Request Already Sent!');
                    return redirect()->back();
                }
                //If not add a new record
                DB::insert('insert into task_user (user_id, task_id) values (?, ?)', [
                    $request->user_id,
                    $request->task_id,
                ]);  
                Session::flash('message', 'Request delivered!');
                return redirect()->back();
            }catch(Exception $e){
                Session::flash('message', $e->getMessage());
                return redirect()->back();
            }

        }else{
            Session::flash('message', 'Not authorized');
            return redirect()->back();
        }
  
    }
 
}
