<?php

namespace App;

use Config;
use App\Company;
use App\Notifications\ResetPasswordNotification;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Staff extends Authenticatable
{
    use Notifiable;

    protected $table = 'staff';

    protected $appends = ['full_name', 'admin_image'];

    protected $fillable = [
    	'company_id',
        'fname',
        'lname',
    	'level',
    	'name',
    	'email',
    	'password',
    	'reset_hash',
    	'phone',
    	'remember_token',
    ];

    const LEVEL = [
        'master'        => 1,
        'company-admin' => 2,
    ];


    public function getFullNameAttribute()
    {
        return str_replace("\n", ' ', $this->fname). ' ' . str_replace("\n", ' ', $this->lname);
    }

    public function getAdminImageAttribute()
    {
        return asset('theme/img/profile_pic.png');
    }

    public function company()
    {
    	return $this->belongsTo('App\Company');
    }

    public function sendPasswordResetNotification($credentials)
    {
        $staff = Staff::whereEmail($credentials['email'])->first();
        $company = Company::find($staff->company_id);
        $configurationSet = $this->setMailConfiguration($company);
        $token = $credentials['token'];

        $from = $company->support_email;

        if ($configurationSet) {
            return false;
        }
        $this->notify(new ResetPasswordNotification($token, $from));
    }

    protected function setMailConfiguration($company)
    {
        $config = [
            'driver'   => $company->smtp_driver,
            'host'     => $company->smtp_host,
            'port'     => $company->smtp_port,
            'username' => $company->smtp_username,
            'password' => $company->smtp_password,
            'encryption' => $company->smtp_encryption,
        ];


        Config::set('mail',$config);
        return false;
    }
}
