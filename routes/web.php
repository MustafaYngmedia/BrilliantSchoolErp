<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/', function (Request $request) {
    if($request->user() == null) {
        return redirect()->route('admin.login');
    }else{
        return redirect()->route('admin.home');
    }
});
Route::get('/admin', function (Request $request) {
    if($request->user() == null) {
        return redirect()->route('admin.login');
    }else{
        return redirect()->route('admin.home');
    }
});

Route::match(['GET','POST'],'/admin/login',"AdminController@login")->name('admin.login');
Route::group(['as'=>'admin.','middleware'=>'auth:admin','prefix'=>'admin'], function(){

    Route::get('/home',"AdminController@home")->name('home');
    Route::get('/admin/list','AdminController@adminList')->name('admin.list');
    Route::get('/admin/add','AdminController@register')->name('admin.register.add');
    Route::post('/admin/add','AdminController@registerPost')->name('admin.register.addPost');
    Route::get('/admin/editRegister/{id}','AdminController@register');
    Route::get('/admin/deleteAdmin/{id}','AdminController@delete');
    Route::get('/logout','AdminController@logout')->name('logout');


    Route::match(['GET','POST'],'/country/list',"Master\CountryController@listAll")->name('country.list');
    Route::match(['GET','POST'],'/country/add/{id?}',"Master\CountryController@add")->name('country.add');
    Route::get('/country/delete/{id?}',"Master\CountryController@delete")->name('country.delete');


    
    Route::match(['GET','POST'],'/state/list',"Master\StateController@listAll")->name('state.list');
    Route::match(['GET','POST'],'/state/add/{id?}',"Master\StateController@add")->name('state.add');
    Route::get('/state/delete/{id?}',"Master\StateController@delete")->name('state.delete');

    
    Route::match(['GET','POST'],'/city/list',"Master\CityController@listAll")->name('city.list');
    Route::match(['GET','POST'],'/city/add/{id?}',"Master\CityController@add")->name('city.add');
    Route::get('/city/delete/{id?}',"Master\CityController@delete")->name('city.delete');

    
    Route::match(['GET','POST'],'/driver/list',"Master\DriverController@listAll")->name('driver.list');
    Route::match(['GET','POST'],'/driver/add/{id?}',"Master\DriverController@add")->name('driver.add');
    Route::get('/driver/delete/{id?}',"Master\DriverController@delete")->name('driver.delete');

    
    Route::match(['GET','POST'],'/brand/list',"Master\BrandController@listAll")->name('brand.list');
    Route::match(['GET','POST'],'/brand/add/{id?}',"Master\BrandController@add")->name('brand.add');
    Route::get('/brand/delete/{id?}',"Master\BrandController@delete")->name('brand.delete');

    
    Route::match(['GET','POST'],'/size/list',"Master\SizeController@listAll")->name('size.list');
    Route::match(['GET','POST'],'/size/add/{id?}',"Master\SizeController@add")->name('size.add');
    Route::get('/size/delete/{id?}',"Master\SizeController@delete")->name('size.delete');


    
    Route::match(['GET','POST'],'/customer/list',"Master\CustomerController@listAll")->name('customer.list');
    Route::match(['GET','POST'],'/customer/add/{id?}',"Master\CustomerController@add")->name('customer.add');
    Route::get('/customer/delete/{id?}',"Master\CustomerController@delete")->name('customer.delete');

    Route::match(['GET','POST'],'/vehicle/list',"Master\VehicleController@listAll")->name('vehicle.list');
    Route::match(['GET','POST'],'/vehicle/add/{id?}',"Master\VehicleController@add")->name('vehicle.add');
    Route::get('/vehicle/delete/{id?}',"Master\VehicleController@delete")->name('vehicle.delete');


    
    Route::match(['GET','POST'],'/load/list',"Master\LoadController@listAll")->name('load.list');
    Route::match(['GET','POST'],'/load/add/{id?}',"Master\LoadController@add")->name('load.add');
    Route::get('/load/delete/{id?}',"Master\LoadController@delete")->name('load.delete');

    
    Route::match(['GET','POST'],'/rate/list',"Master\RateController@listAll")->name('rate.list');
    Route::match(['GET','POST'],'/rate/add/{id?}',"Master\RateController@add")->name('rate.add');
    Route::get('/rate/delete/{id?}',"Master\RateController@delete")->name('rate.delete');


    Route::match(['GET','POST'],'/booking/add/{id?}',"BookingController@add")->name('booking.add');
    Route::match(['GET','POST'],'/booking/list',"BookingController@list")->name('booking.list');
    Route::get('/booking/delete/{id?}',"BookingController@delete")->name('booking.delete');


    
    Route::match(['GET','POST'],'/booking/ledgder/{id?}',"BookingController@addLedger")->name('booking.ledger');
    Route::match(['GET','POST'],'/booking/ledgder-delete{id?}',"BookingController@deleteLedger")->name('booking.ledger.delete');

    Route::match(['GET','POST'],'/booking/get_kms',"BookingController@get_kms")->name('booking.get_kms');
    Route::match(['GET','POST'],'/get_citys_by_state',"BookingController@get_citys_by_state")->name('get_citys_by_state');
    Route::get('/invoice/{id}',"BookingController@getInvoice")->name('booking.getInvoice');



});


