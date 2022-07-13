<?php

namespace App\Http\Controllers;

use DateTime;
use App\Models\User;
use App\Models\member;
use App\Mail\MailToDPW;
use App\Mail\SendEmail;
use App\Models\Wilayah;
use App\Models\register;
use App\Models\TemplateMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Crypt;
use Symfony\Component\HttpFoundation\Response;

class RegistrasiMember extends Controller
{
    public function index(){
        $data=register::with('wilayah','Cities','CompanyIndustry')->get();
        $response =[
            'message' => 'succes menampilkan data register',
            'data' => $data
       ];
       return response()->json($response,Response::HTTP_OK);
    }
    public function register(Request $request){
        
        $cek=register::where('email',$request->email)->first();
      
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
            'username'=>'required|string',
            'namaPerushaan'=>'required|string',
            'nomor'=>'required|string',
            'companyindustry'=>'required',
            'KotaId'=>'required',
            'WilayahId'=>'required',
            'bentukusaha'=>'required',
            'alasan'=>'required',

        ]);
       $registrasi=register::where('username',$request->username)->first();
        if($registrasi){
            return response()->json([
                'message'=>"username sudah tersedia"
            ]); 
        }
        if (!$cek){
        date_default_timezone_set('Asia/Jakarta');
        $ldate = new DateTime('now');

        $user= register::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' =>Crypt::encryptString($request->password),
            'Username' => $request->username,
            'NamaPerushaan'=>$request->namaPerushaan,
            'PhoneNumber' =>$request->nomor,
            'CompanyIndustryId' => $request->companyindustry,
            'WilayahId' => $request->KotaId,
            'KotaId' => $request->KotaId,
            'BentukBadanUsaha' => $request->bentukusaha,
            'AlasanBergabung' => $request->alasan,
            'RegisterDate' => $ldate,
            'status_DPP'=>"menunggu verifikasi",
            'status_DPW'=>"menunggu verifikasi",
            'status' =>'aktif',
            'roles'=>'member'
        ]);
      
        
        $email = $request->email;
        $name= $request->name;
        $datamail= TemplateMail::where('name','regis')->first();
        // dd($data);
        $mail=$datamail->template;
        Mail::to($email)->send(new SendEmail($name,$mail));
        $data= TemplateMail::where('name','regisDPP')->first();
        $mail=$data->template;
        $tujuan=$data->tujuan;
        Mail::to($tujuan)->send(new MailToDPW($name,$mail));
        return response()->json([
            'status' => 'success',
            'message' => 'User created successfully',
            'user' => $user,
        ]);
    } else{
        return response()->json([
            'message'=>"anda sudah terdaptar"
        ]);
    }
    }
    public function rejectedDPP($id){
        // dd($id);
        $data=register::find($id);
        $data->status_DPP='ditolak';
        $email=$data->email;
        $name=$data->name;
        $data->save();
        // $data=register::where('id',$id)->first();
      
        
        $dataMail= TemplateMail::where('name','ditolakDPP')->first();
        $mail=$dataMail->template;
        Mail::to($email)->send(new SendEmail($name,$mail));
        return response()->json([
            'status' => 'success update',
      
            
        ]);
    }
    public function rejectedDPW($id){
        // dd($id);
        $data=register::find($id);
        $data->status_DPW='ditolak';
        $email=$data->email;
        $name=$data->name;
        $data->save();
        // dd($email);
        // $data=register::where('id',$id)->first();
        $dataMail= TemplateMail::where('name','ditolakDPW')->first();
        $mail=$dataMail->template;
        Mail::to($email)->send(new SendEmail($name,$mail));
        return response()->json([
            'status' => 'success update',
      
        ]);
       
       
    }
   
    public function ApprovedDPP($id){
        // dd($id);
        
        $data=register::find($id);
      
        $data->status_DPP='disetujui';
        $email=$data->email;
        $name=$data->name;
        $data->save();
        // $data=register::where('id',$id)->first();
      
        $dataMail= TemplateMail::where('name','dppsetuju')->first();
        $mail=$dataMail->template;
        Mail::to($email)->send(new SendEmail($name,$mail));
        $dataMailDPP= TemplateMail::where('name','disetujuiDPP')->first();
        $mail=$dataMailDPP->template;
        $emailDPP=$dataMailDPP->tujuan;
        Mail::to($emailDPP)->send(new MailToDPW($name,$mail));
        return response()->json([
            'status' => 'success update',
      
            
        ]); 
    }
    public function ApprovedDPW($id){
        // dd('cek');
        $data=register::find($id);
        if( $data->status_DPP == 'disetujui'){
        $data->status_DPW='disetujui';
        $email=$data->email;
        $name=$data->name;
        $data->save();
        $dataMail= TemplateMail::where('name','dpwsetuju')->first();
        $mail=$dataMail->template;
        Mail::to($email)->send(new SendEmail($name,$mail));
        $user = user::create([
            'name' => $data->name,
            'email' => $data->email,
            'password' => $data->password,
            'username' => $data->username,
            'NamaPerushaan'=>$data->NamaPerushaan,
            'PhoneNumber' =>$data->PhoneNumber,
            'CompanyIndustryId' => $data->CompanyIndustryId,
            'WilayahId'=>$data->WilayahId,
            'KotaId' => $data->KotaId,
            'BentukBadanUsaha' => $data->BentukBadanUsaha,
            'AlasanBergabung' => $data->AlasanBergabung,
            'RegisterDate' => $data->RegisterDate,
            'status' =>'aktif',
            'roles'=>'member'

        ]);
        
        $member = member::create([
            'name' => $data->name,
            'email' => $data->email,
            'password' => $data->password,
            'username' => $data->username,
            'NamaPerushaan'=>$data->NamaPerushaan,
            'PhoneNumber' =>$data->PhoneNumber,
            'CompanyIndustryId' => $data->CompanyIndustryId,
            'WilayahId'=>$data->WilayahId,
            'KotaId' => $data->KotaId,
            'BentukBadanUsaha' => $data->BentukBadanUsaha,
            'AlasanBergabung' => $data->AlasanBergabung,
            'RegisterDate' => $data->RegisterDate,
            'status' =>'aktif',
            'roles'=>'member'

        ]);
        
       
        $token = Auth::login($user);
        return response()->json([
            'status' => 'success',
            'message' => 'User created successfully',
            'user' => $user,
            'authorisation' => [
                'token' => $token,
                'type' => 'bearer',
            ]
        ]);
        }else{
            return response()->json([
                'status' => 'belum disetujui DPP',
            ]); 
        } 
    }
    public function MemberStatus(Request $request){
        // dd($request->nama);
        $data=member::where('status',$request->status)->get();
        // dd($data);
        return response()->json([
            'data' => $data,           
        ]);  
          
    }
    public function MemberWilayah(Request $request){
       $wilayah=Wilayah::where('name',$request->name)->first();
       $data=member::where('WilayahId',$wilayah->id)->get();
    // $data=member::with('Wilayah')->get();
        return response()->json([
            'data' => $data,           
        ]);       
    }


}
