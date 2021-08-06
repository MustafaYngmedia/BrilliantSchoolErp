<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Country;
use App\User;
use App\Size;
use DataTables;
class CustomerController extends Controller
{
    private $main_heading = "Customer ";
    private $table = 'App\User';
    private $view_list = "admin.customer.list";
    private $list_url = "admin.customer.list";
    private $view_form = "admin.customer.add";
    private $add_url = "admin.customer.add";
    private $delete_url = "admin.customer.delete";
    private $message_save = "Customer Updated !!";
    private $message_delete = "Customer Deleted !!";

    public function add(Request $request,$id = null){

        if($request->method() == 'GET'){
            $heading = $id == null ? 'Add '.$this->main_heading : 'Update '.$this->main_heading;
            $type = $id == null ? 'Add' : 'Update';
            $form_data = null;
            $main_heading = $this->main_heading;
            $add_url = $this->add_url;
            if($id != null){
                $form_data = $this->table::find($id);
            }
            return view($this->view_form,compact('main_heading','type','heading','id','form_data','add_url'));
        }

        if($request->method() == 'POST'){
            if($id == null){
                $instance = new $this->table;
                $request->validate([
                    'first_name'=>'required',
                    'last_name'=>'required',
                    'mobile'=>'required',
                    'email'=>'required',
                    'type'=>'required',
                    'status'=>'required',
                ]);
            }else{
                $instance = $this->table::find($id);
            }
            $instance->first_name = $request->first_name;
            $instance->last_name = $request->last_name;
            $instance->mobile = $request->mobile;
            $instance->email = $request->email;
            $instance->company_name = $request->company_name;
            $instance->type = $request->type;
            $instance->status = $request->status;

            $instance->save();
            return redirect()->route($this->list_url)->with('message',$this->message_save);
        }
    }
    public function listAll(Request $request){
        $add_button = "Add ".$this->main_heading;
        $main_heading = $this->main_heading;     
        $add_url = $this->add_url;
        $list_url = $this->list_url;


        if ($request->ajax()){
            $data = $this->table::select('id','first_name','last_name','mobile','type','status')->latest();
            if($request->name != ""){
                $data->where('first_name','like','%'.$request->name.'%');
            }
            if($request->mobile != ""){
                $data->where('mobile','like','%'.$request->mobile.'%');
            }
            if($request->email != ""){
                $data->where('email','like','%'.$request->email.'%');
            }
            if($request->company_name != ""){
                $data->where('company_name','like','%'.$request->company_name.'%');
            }
            if($request->status != ""){
                $data->where('status',$request->status);
            }
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
                        $add_href = route($this->add_url,['id'=>$row->id]);
                        $delete_url = route($this->delete_url,['id'=>$row->id]);
                        $actionBtn = '<a class="edit btn btn-success btn-sm" href="'.$add_href.'">Edit</a> <a href="'.$delete_url.'" class="delete btn btn-danger delete-button btn-sm" onclick="return confirm('."'Are you sure you want to delete this row'".')">Delete</a>';
                        return $actionBtn;
                    })
                    ->addColumn('status_raw', function($row){
                        $type = $row->status == 1 ? "Active" : "InActive"; 
                        return $type;
                    })
                    
                    ->addColumn('type', function($row){
                        $type = $row->type == 1 ? "B2B" : "B2C"; 
                        return $type;
                    })
                    ->addColumn('name', function($row){
                        return $row->first_name.' '.$row->last_name;
                    })
                    ->rawColumns(['action','type','name','status_raw'])
                    ->make(true);
        }
        return view($this->view_list,compact('main_heading','add_button','add_url','list_url'));
    }
    public function delete(Request $request,$id){
        $this->table::find($id)->delete();
        return redirect()->route($this->list_url)->with('message',$this->message_delete);
    }
}
