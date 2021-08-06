<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Country;
use App\Brand;
use App\Rate;
use App\Size;

use DataTables;
class RateController extends Controller
{
    private $main_heading = "Rate ";
    private $table = 'App\Rate';
    private $view_list = "admin.rate.list";
    private $list_url = "admin.rate.list";
    private $view_form = "admin.rate.add";
    private $add_url = "admin.rate.add";
    private $delete_url = "admin.rate.delete";
    private $message_save = "Rate Updated !!";
    private $message_delete = "Rate Deleted !!";
    private $size_type = ["1" => "ft", "2" => "Cm","3"=>"Meter"];

    public function add(Request $request,$id = null){

        if($request->method() == 'GET'){
            $heading = $id == null ? 'Add '.$this->main_heading : 'Update '.$this->main_heading;
            $type = $id == null ? 'Add' : 'Update';
            $form_data = null;
            $add_url = $this->add_url;
            $size_type = $this->size_type;
            $all_sizes = Size::latest()->where('status',1)->get();
            if($id != null){
                $form_data = $this->table::find($id);
            }
            return view($this->view_form,compact('size_type','all_sizes','type','heading','id','form_data','add_url'));
        }

        if($request->method() == 'POST'){
            if($id == null){
                $instance = new $this->table;
                $instance->created_by = $request->user()->id;
                $request->validate([
                    'size_id'=>'required',
                    'min_range'=>'required',
                    'max_range'=>'required',
                    'fixed_price'=>'required',
                    'amount'=>'required',
                    'status'=>'required',
                ]);
            }else{
                $instance = $this->table::find($id);
                $instance->updated_by = $request->user()->id;
            }
            $instance->size_id = $request->size_id;

            $instance->min_range = $request->min_range;
            $instance->max_range = $request->max_range;
            $instance->fixed_price = $request->fixed_price;
            $instance->amount = $request->amount;
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
            $data = $this->table::with('size')->latest()->get();
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
                    ->addColumn('size', function($row){
                        $size_name = isset($row->size->name) ? $row->size->name : '';
                        if($size_name){
                            return $size_name.' '.$this->size_type[$row->size->type];
                        }
                    })
                    ->rawColumns(['action','size','status_raw'])
                    ->make(true);
        }
        return view($this->view_list,compact('main_heading','add_button','add_url','list_url'));
    }
    public function delete(Request $request,$id){
        $this->table::find($id)->delete();
        return redirect()->route($this->list_url)->with('message',$this->message_delete);
    }
}
