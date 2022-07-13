<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CitiesController;
use App\Http\Controllers\RegistrasiMember;
use App\Http\Controllers\WilayahController;
use App\Http\Controllers\OperatorController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\CompanyIndustryController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::post('register', [AuthController::class,'register']);
    Route::post('forgot', [ForgotPasswordController::class,'forgot']);
    Route::post('updateStatus/{id}', [OperatorController::class,'UpdateStatus']);
    Route::post('detailUser', [OperatorController::class,'detailUser']);
    Route::post('updateUser/{id}', [OperatorController::class,'updateUser']);
    
    Route::get('userRegister', [RegistrasiMember::class,'index']);
    Route::post('listMeberStatus', [RegistrasiMember::class,'MemberStatus']);
    Route::post('listMeberWilayah', [RegistrasiMember::class,'MemberWilayah']);
    

    Route::post('register', [RegistrasiMember::class,'register']);
   
    Route::post('/ditolak/{id}', [RegistrasiMember::class,'rejectedDPP']);
    Route::post('/ditolakDPW/{id}', [RegistrasiMember::class,'rejectedDPW']);
    Route::post('/disetujuiDPP/{id}', [RegistrasiMember::class,'ApprovedDPP']);
    Route::post('/disetujuiDPW/{id}', [RegistrasiMember::class,'ApprovedDPW']);


 

     //Cities
     Route::post('/cities', [CitiesController::class,'store']);
     Route::get('/cities', [CitiesController::class,'index']);
     Route::post('/cities/{id}', [CitiesController::class,'update']);
     Route::get('/cities/{id}', [CitiesController::class,'show']);
     Route::delete('/cities/{id}', [CitiesController::class,'destroy']);

     // wilayah
     Route::post('/wilayah', [WilayahController::class,'store']);
     Route::get('/wilayah', [WilayahController::class,'index']);
     Route::post('/wilayah/{id}', [WilayahController::class,'update']);
     Route::get('/wilayah/{id}', [WilayahController::class,'show']);
     Route::delete('/wilayah/{id}', [WilayahController::class,'destroy']);

// //company industri
Route::post('/industry', [CompanyIndustryController::class,'store']);
Route::get('/industry', [CompanyIndustryController::class,'index']);
Route::post('/industry/{id}', [CompanyIndustryController::class,'update']);
Route::get('/industry/{id}', [CompanyIndustryController::class,'show']);
Route::delete('/industry/{id}', [CompanyIndustryController::class,'destroy']);

Route::post('login', [AuthController::class,'login']);
Route::post('logout', [AuthController::class,'logout']);

Route::group(['middleware' => 'admin'], function(){
        //company industri
        // Route::post('/industry', [CompanyIndustryController::class,'store']);
        // Route::get('/industry', [CompanyIndustryController::class,'index']);
        // Route::post('/industry/{id}', [CompanyIndustryController::class,'update']);
        // Route::get('/industry/{id}', [CompanyIndustryController::class,'show']);
        // Route::delete('/industry/{id}', [CompanyIndustryController::class,'destroy']);
   
});
Route::group(['middleware' => 'auth'], function(){
        
    
});
Route::group(['middleware' => 'operator'], function(){
        
    
});