<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class AdminTaskController extends Controller
{
    //
    public function index(){
        $tasks = DB::table('tasks')->paginate(20);         
        return view('admin.index', compact('tasks'));
    }

    public function create(){
        return view('admin.create');
    }

    public function store(Request $request){

        $this->validate($request, [
            'title' =>'required',
            'description' => 'required',
            'department_id'=>'required',
            'assets'=>'url',
            'resources'=>'url',
            'start_date' => 'required|date',
            'deadline' => 'required|date|after:start_date',
            'budget' => 'required'
        ]);
        
        try{
            DB::beginTransaction();
           
            DB::insert('insert into tasks(title, description, department_id, assets, resources, start_date, deadline, budget) values (?, ?, ?, ?, ?, ?, ?, ?)', [
                $request->title,
                $request->description,
                $request->department_id,
                $request->assets,
                $request->resources,
                $request->start_date,
                $request->deadline,
                $request->budget,
            ]);

            $id = DB::table('tasks')->get()->last()->id;

            foreach ($request->requirements as $req){
                DB::insert('insert into requirements (body, task_id) values (?, ?)', [
                    $req,
                    $id,
                ]);
            }

            DB::commit();

            Session::flash('message', 'Task Created!');
            return redirect(route('dashboard'));
        
        } catch(Exception $e) {
            DB::rollBack();
            Session::flash('message', $e->getMessage());
            return redirect(route('dashboard'));
        } 
        
    }

    public function edit($id){
        $task_details = DB::table('tasks')->where('id', $id)->get()->first();
        $departments = DB::table('departments')->get();
        $requirements = DB::table('requirements')->where('task_id', $id)->get();
        return view('admin.edit', compact(['task_details', 'departments', 'requirements']));
    }


    public function update(Request $request, $id){

        $this->validate($request, [
            'title' =>'required',
            'description' => 'required',
            'department_id'=>'required',
            'assets'=>'url',
            'resources'=>'url',
            'start_date' => 'required|date',
            'deadline' => 'required|date|after:start_date',
            'budget' => 'required'
        ]);

        try{
            DB::beginTransaction();
           
            DB::table('tasks')->where('id', $id)->update([  'title' => $request->title,
                                                            'description' => $request->description,
                                                            'department_id' => $request->department_id,
                                                            'assets' => $request->assets,
                                                            'resources' => $request->resources,
                                                            'start_date' => $request->start_date,
                                                            'deadline' =>  $request->deadline,
                                                            'budget' => $request->budget,
                                                        ]);

            DB::table('requirements')->where('task_id', $id)->delete();
            foreach ($request->requirements as $req){
                DB::insert('insert into requirements (body, task_id) values (?, ?)', [
                    $req,
                    $id,
                ]);
            }

            DB::commit();
            Session::flash('message', 'Task Updated!');
            return redirect(route('dashboard'));
        
        } catch(Exception $e) {
            DB::rollBack();
            Session::flash('message', $e->getMessage());
            return redirect(route('dashboard'));
        } 
    }

    public function displayClaimRequests(){
        $requested_tasks = DB::select( DB::raw("select task_id, user_id, title, name from tasks 
                                             join task_user on tasks.id = task_user.task_id
                                             join users on users.id = task_user.User_id 
                                             where approved != -1
                                             and task_id not in (select task_id from task_user where approved = 1); "));
                            
        return view('admin.requests', compact('requested_tasks'));
    }


    public function respondeToClaimRequest(Request $request){
        $user_id = $request->user_id;
        $task_id = $request->task_id;

        try{
            DB::table('task_user')->where('user_id', $user_id)
                            ->where('task_id', $task_id)
                            ->update(['approved' => $request->approve]);
        
            if($request->approve == 1){
                DB::table('tasks')->where('id', $task_id)
                ->update(['assigned_user_id' => $user_id]);
            }

            Session::flash('message', 'Request Approved!'); 
            return redirect()->back();       
        }catch(Exception $e){
            Session::flash('message', $e->getMessage()); 
            return redirect()->back();  
        }
    }    
}
