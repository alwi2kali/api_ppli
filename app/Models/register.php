<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class register extends Model
{
    use HasFactory;
    protected $fillable = [
       
        'name',
        'email',
        'password',
        'Username',
        'Email_verified_at',
        'Password',
        'NamaPerushaan',
        'PhoneNumber',
        'CompanyIndustryId',
        'WilayahId',
        'KotaId',
        'BentukBadanUsaha',
        'AlasanBergabung',
        'status_DPP',
        'status_DPW',
        'RegisterDate',
        'status',
        'roles'
    ];
    public function Cities ()
    {
        return $this->belongsTo(Cities::class,'KotaId','id');
    }
    public function CompanyIndustry ()
    {
        return $this->belongsTo(Wilayah::class,'CompanyIndustryId','id');
    }
   
    public function Wilayah ()
    {
        return $this->belongsTo(Wilayah::class,'WilayahId','id');
    }

}
