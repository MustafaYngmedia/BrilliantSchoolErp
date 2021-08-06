<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Country;
use App\Vehicle;
use App\User;
use App\Driver;
use App\Brand;
use App\Size;
use App\DriverChangeLog;
use DataTables;
class VehicleController extends Controller
{
    private $main_heading = "Vehicle ";
    private $table = 'App\Vehicle';
    private $view_list = "admin.vehicle.list";
    private $list_url = "admin.vehicle.list";
    private $view_form = "admin.vehicle.add";
    private $add_url = "admin.vehicle.add";
    private $delete_url = "admin.vehicle.delete";
    private $message_save = "Vehicle Updated !!";
    private $message_delete = "Vehicle Deleted !!";
    private $size_type = ["1" => "ft", "2" => "Cm","3"=>"Meter"];


    public function add(Request $request,$id = null){

        if($request->method() == 'GET'){
            $heading = $id == null ? 'Add '.$this->main_heading : 'Update '.$this->main_heading;
            $type = $id == null ? 'Add' : 'Update';
            $form_data = null;
            $main_heading = $this->main_heading;
            $add_url = $this->add_url;
            $all_brands = Brand::latest()->where('status',1)->get();
            $all_drivers = Driver::latest()->where('status',1)->get();
            $size_type = $this->size_type;
            $all_sizes = Size::latest()->where('status',1)->get();
            $all_driver_change_log = DriverChangeLog::with(['driver','admin'])->latest()->where('status',1)->get();
            if($id != null){
                $form_data = $this->table::find($id);
            }
            return view($this->view_form,compact('all_driver_change_log','all_sizes','size_type','all_drivers','all_brands','main_heading','type','heading','id','form_data','add_url'));
        }

        if($request->method() == 'POST'){
            $request->validate([
                'vehicle_number'=>'required',
                'model'=>'required',
                'vehicle_type'=>'required',
                'permit_type'=>'required',
                'fuel_type'=>'required',
                'brand_id'=>'required',
                'size_id'=>'required',
                'status'=>'required',
            ]);
            if($id == null){
                $instance = new $this->table;
                $instance->created_by = $request->user()->id;
            }else{
                $instance = $this->table::find($id);
                $instance->updated_by = $request->user()->id;
            }
            $instance->vehicle_number = $request->vehicle_number;
            $instance->model = $request->model;
            $instance->vehicle_type = $request->vehicle_type;
            $instance->permit_type = $request->permit_type;
            $instance->fuel_type = $request->fuel_type;
            $instance->brand_id = $request->brand_id;

            $instance->size_id = $request->size_id;
            $instance->width = $request->width;
            $instance->height = $request->height;
            $instance->weight = $request->weight;

            if($instance->current_driver_id != $request->current_driver_id){
                DriverChangeLog::create([
                    'vehicle_id'=>$id,
                    'driver_id'=>$request->current_driver_id,
                    'created_by'=>$request->user()->id
                ]);
            }
            // $instance->base_price = $request->base_price;
            // $instance->base_km = $request->base_km;
            // $instance->per_km = $request->per_km;
            $instance->current_pincode = $request->current_pincode;
            $instance->current_driver_id = $request->current_driver_id;

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
        $all_brands = Brand::latest()->where('status',1)->get();


        if ($request->ajax()){
            $data = $this->table::with('brand')->latest();
            if($request->model != ""){
                $data->where('model','like','%'.$request->model.'%');
            }
            if($request->vehicle_number != ""){
                $data->where('vehicle_number','like','%'.$request->vehicle_number.'%');
            }
            if($request->status != ""){
                $data->where('status',$request->status);
            }
            if($request->permit_type != ""){
                $data->where('permit_type',$request->permit_type);
            }
            if($request->fuel_type != ""){
                $data->where('fuel_type',$request->fuel_type);
            }
            if($request->brand_id != ""){
                $data->where('brand_id',$request->brand_id);
            }
            if($request->vehicle_type != ""){
                $data->where('vehicle_type',$request->vehicle_type);
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
                    
                    ->addColumn('brand', function($row){
                        return isset($row->brand->name) ? $row->brand->name : '';
                    })
                
                    ->rawColumns(['action','status_raw'])
                    ->make(true);
        }
        return view($this->view_list,compact('main_heading','all_brands','add_button','add_url','list_url'));
    }
    public function delete(Request $request,$id){
        $this->table::find($id)->delete();
        return redirect()->route($this->list_url)->with('message',$this->message_delete);
    }
}
