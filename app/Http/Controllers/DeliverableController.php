<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Session;

class DeliverableController extends Controller
{
    //These methods are for users 
    public function create($id){
        //Make sure task is completed to allow for delivery request creation
        $progress = DB::table('tasks')->where('id', $id)->get()->first()->progress;
        if($progress == 1 ){
            return view('user.create');
        }
        Session::flash('message', 'Task Not Completed Yet!');
        return redirect()->back();
    }

    public function store(Request $request){

        $this->validate($request, [
            'title' =>'required',
            'description' => 'required|min:5',
            'file'=>'required',
        ]);

        //Store the file that needs to be delivered in a directory called deliverables in storage 
        $deliverable = $request->file('file')->store('deliverables/');
        try{
            DB::insert('insert into deliverables(title, description, file_path, user_id) values (?, ?, ?, ?)', [
                $request->title,
                $request->description, 
                $deliverable,
                $request->user_id,
            ]);      

            Session::flash('message', 'Request Created!');
            return redirect(route('user.index'));

        }catch(Exception $e){
            Session::flash('message', $e->getMessage());
            return redirect(route('user.index'));
        }
          
    }
    

    //These methods are for admins
    public function index(){
        $deliverables = DB::table('deliverables')->where('approved', null)->get();
        return view('admin.deliverables', compact('deliverables'));
     }
 
     public function respondToDeliveryRequest(Request $request){
         try{
             DB::table('deliverables')->where('id', $request->id)
             ->update(['approved' => $request->approve]);
     
             if($request->approve == 0){
                 $deliverable_path = DB::table('deliverables')->where('id', $request->id)->get('file_path')->first();
                 $path = $deliverable_path->file_path;
                 Storage::delete($path);
             }
             Session::flash('message', 'Responded to Request!');
             return redirect()->back();   
             
         }catch(Exception $e){
             Session::flash('message', $e->getMessage());
             return redirect()->back();  
         }    
     }
 
     public function download($id){
         $deliverable_path = DB::table('deliverables')->where('id', $id)->get('file_path')->first();
         $path = $deliverable_path->file_path;
         return Storage::download($path);
     }
}
