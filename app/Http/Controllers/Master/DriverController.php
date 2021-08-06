<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\State;
use App\City;
use App\Driver;
use App\Country;

use DataTables;
class DriverController extends Controller
{
    private $main_heading = "Driver ";
    private $table = 'App\Driver';
    private $view_list = "admin.driver.list";
    private $list_url = "admin.driver.list";
    private $view_form = "admin.driver.add";
    private $add_url = "admin.driver.add";
    private $delete_url = "admin.driver.delete";
    private $add_message = "Driver Updated";
    private $delete_message = "Driver Delete";

    public function add(Request $request,$id = null){

        if($request->method() == 'GET'){
            $heading = $id == null ? 'Add '.$this->main_heading : 'Update '.$this->main_heading;
            $type = $id == null ? 'Add' : 'Update';
            $form_data = null;
            $add_url = $this->add_url;
            if($id != null){
                $form_data = $this->table::find($id);
            }
            return view($this->view_form,compact('type','heading','id','form_data','add_url'));
        }

        if($request->method() == 'POST'){
            if($id == null){
                $instance = new $this->table;
                $request->validate([
                    'name'=>'required',
                    'mobile'=>'required',
                    'status'=>'required',
                ]);
            }else{
                $instance = $this->table::find($id);
            }
            $instance->name = $request->name;
            $instance->mobile = $request->mobile;
            $instance->license_number = $request->license_number;
            $instance->status = $request->status;

            $instance->save();
            return redirect()->route($this->list_url)->with('message',$this->add_message);
        }
    }
    public function listAll(Request $request){
        $add_button = "Add ".$this->main_heading;
        $main_heading = $this->main_heading;     
        $add_url = $this->add_url;
        $list_url = $this->list_url;


        if ($request->ajax()){
            $data = $this->table::select('id','name','mobile','license_number','status')->latest();
            if($request->name != ""){
                $data->where('name','like','%'.$request->name.'%');
            }
            if($request->mobile != ""){
                $data->where('mobile','like','%'.$request->mobile.'%');
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
                    ->rawColumns(['action','mobile','status_raw'])
                    ->make(true);
        }
        return view($this->view_list,compact('main_heading','add_button','add_url','list_url'));
    }
    public function delete(Request $request,$id){
        $this->table::find($id)->delete();
        return redirect()->route($this->list_url)->with('message',$this->delete_message);
    }
}
