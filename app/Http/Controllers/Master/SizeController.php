<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Country;
use App\Size;
use DataTables;
class SizeController extends Controller
{
    private $main_heading = "Size ";
    private $table = 'App\Size';
    private $view_list = "admin.size.list";
    private $list_url = "admin.size.list";
    private $view_form = "admin.size.add";
    private $add_url = "admin.size.add";
    private $delete_url = "admin.size.delete";
    private $message_save = "Size Updated !!";
    private $message_delete = "Size Deleted !!";

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
                    'name'=>'required',
                    'type'=>'required',
                    'status'=>'required',
                ]);
            }else{
                $instance = $this->table::find($id);
            }
            $instance->name = $request->name;
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
            $data = $this->table::select('id','name','type','status')->latest()->get();
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
                        $size_type = [1=> "ft",2=>'Cm',3=>'Meter'];
                        return $size_type[$row->type];
                    })
                    ->rawColumns(['action','type','status_raw'])
                    ->make(true);
        }
        return view($this->view_list,compact('main_heading','add_button','add_url','list_url'));
    }
    public function delete(Request $request,$id){
        $this->table::find($id)->delete();
        return redirect()->route($this->list_url)->with('message',$this->message_delete);
    }
}
