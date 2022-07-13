<?php

namespace App\Models;

use App\Models\Cities;
use App\Models\Wilayah;
use App\Models\CompanyIndustry;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class member extends Model
{
    use HasFactory;
    protected $fillable = [
       
        'name',
        'email',
        'password',
        'username',
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
