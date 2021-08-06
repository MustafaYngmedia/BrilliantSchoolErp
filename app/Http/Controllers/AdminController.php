<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Hash;
use App\Admin;
use App\State;
use App\Brand;
use App\User;
use App\Driver;
use App\Vehicle;
use App\City;
use App\UserRole;
use Faker\Generator as Faker;
use DataTables;



class AdminController extends Controller
{
    private $main_heading = "Admin ";
    private $table = 'App\Admin';
    private $view_list = "admin.admin.user.list";
    private $list_url = "admin.user.list";
    private $view_form = "admin.auth.register";
    private $add_url = "admin.user.register.add";
    private $delete_url = "admin.user.delete";
    private $message_save = "User Updated !!";
    private $message_delete = "User Deleted !!";

    public function login(Request $request){
        if($request->method() == 'POST'){
            $credentials = $request->except(['_token']);
            if(Auth::guard('admin')->attempt($request->only('email','password'),$request->filled('remember')))
            {   
                return redirect()->route('admin.home');
            }            
            return back()->withErrors(['error'=>'Credentials not matced in our records!']);
        }
        return view('admin.auth.login');
    }
    public function registerPost(Request $request){
        $request->validate([
            'name'=>'required',
            'email'=>'required',
        ]);
        if($request->id != null){
            $admin =  User::find($request->id);
        }else{
            $admin =  new User;
        }
        $admin->name = $request->name;
        $admin->email = $request->email;
        if($request->password){
            $admin->password = Hash::make($request->password);
        }
        $admin->save();
        return redirect()->route('admin.admin.list');
    }
    public function add(Request $request,$id = null){

        if($request->method() == 'GET'){
            $heading = $id == null ? 'Add '.$this->main_heading : 'Update '.$this->main_heading;
            $type = $id == null ? 'Add' : 'Update';
            $form_data = null;
            $add_url = $this->add_url;
            $all_managers = User::whereIn('id',[1,2])->get();
            $all_user_roles = UserRole::where('status',1)->latest()->get();
            if($id != null){
                $form_data = $this->table::find($id);
            }
            return view($this->view_form,compact('all_managers','all_user_roles','type','heading','id','form_data','add_url'));
        }

        if($request->method() == 'POST'){
            if($id == null){
                
                $request->validate([
                    'first_name'=>'required',
                    'last_name'=>'required',
                    'status'=>'required',
                    'email'=>'required|unique:users,email'
                ]);
                $instance = new $this->table;
                $instance->created_by = $request->user()->id;
                $instance->password = Hash::make($request->password);
            }else{
                $instance = $this->table::find($id);
                $instance->updated_by = $request->user()->id;
                if($request->password){
                    $instance->password = Hash::make($request->password);
                }
            }
            $instance->reporting_to = $request->reporting_to;
            $instance->email = $request->email;
            $instance->mobile = $request->mobile;
            $instance->first_name = $request->first_name;
            $instance->last_name = $request->last_name;
            $instance->user_role = $request->user_role;
            $instance->reporting_to = $request->reporting_to;
            $instance->status = $request->status;
            $instance->save();
            return redirect()->route($this->list_url)->with('message',$this->message_save);
        }
    }
    public function delete(Request $request,$id){
        $admin = User::find($id);
        if($admin == null){
            die("Cannot Find Admin");
        }
        $admin->delete();
        return redirect()->route('user.list');

    }
    public function adminList(Request $request){
        $add_button = "Add ".$this->main_heading;
        $main_heading = $this->main_heading;     
        $add_url = $this->add_url;
        $list_url = $this->list_url;
        $all_user_roles = UserRole::where('status',1)->latest()->get();
        $heading = "User List";
        if ($request->ajax()){
            $data = User::with('role')->latest();
            $user = Auth::user();
            if($user->user_role == 2){
                $data->where('user_role',3)->where('reporting_to',$user->id);
            }
            if($request->status != ""){
                $data->where('status',$request->status);
            }
            if($request->mobile != ""){
                $data->where('mobile','like','%'.$request->mobile.'%');
            }
            if($request->name != ""){
                $data->where('first_name','like','%'.$request->name.'%')->Orwhere('last_name','like','%'.$request->name.'%');
            }
            if($request->user_role != ""){
                $data->where('user_role',$request->user_role);
            }
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
                        $add_href = route('user.register.add',['id'=>$row->id]);
                        $delete_url = route('user.delete',['id'=>$row->id]);
                        $actionBtn = '<a class="edit btn btn-success btn-sm" href="'.$add_href.'">Edit</a> <a href="'.$delete_url.'" class="delete btn btn-danger delete-button btn-sm" onclick="return confirm('."'Are you sure you want to delete this row'".')">Delete</a>';
                        return $actionBtn;
                    })
                    ->addColumn('name', function($row){
                        return $row->first_name.' '.$row->last_name;
                    })
                    ->addColumn('role', function($row){
                        return $row->role->name;
                    })
                    ->addColumn('status_raw', function($row){
                        $type = $row->status == 1 ? "Active" : "InActive"; 
                        return $type;
                    })
                    ->rawColumns(['action','role','status_raw'])
                    ->make(true);
        }
        return view('admin.auth.list',compact('all_user_roles','heading','main_heading','add_button','add_url','list_url'));
    }
    public function logout()
    {
        Auth::guard()->logout();
        return redirect()
            ->route('admin.login')
            ->with('status','Admin has been logged out!');
    }
    public function home(){
        return view('admin.pages.dashboard');
    }
}
