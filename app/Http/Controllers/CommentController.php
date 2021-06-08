<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CommentController extends Controller
{
    //

    public function makeComment(Request $request){

        $this->validate($request, [
            'body' =>'required',
        ]);
        try{
            DB::insert('insert into comments(body, commentable_id, commentable_type, user_id) values (?, ?, ?, ?)', [
                $request->body,
                $request->commentable_id, 
                $request->commentable_type, 
                $request->user_id,
            ]);
            $user_name = auth()->user()->name;
            return response()->json([
                'bool' => true,
                'user_name' => $user_name,
                'comment' => $request->body,
            ]);
        }catch(Exception $e){
            return response()->json([
                'bool' => false
            ]);
        }
    }

    public function returnComments(int $id){
        $task = DB::table('tasks')->where('id', $id)->first();
        $comments = DB::table('comments')->where('commentable_id', $id)
                                         ->get();
     
        $requirments = DB::table('requirements')->where('task_id', $id)->get();

        return view('task', compact('task', 'requirments','comments'));
    }
}
