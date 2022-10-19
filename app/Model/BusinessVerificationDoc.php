<?php

namespace App\Model;

use App\Model\SystemGlobalSetting;
use Illuminate\Support\Facades\File;
use Illuminate\Database\Eloquent\Model;

class BusinessVerificationDoc extends Model
{
    protected $table = 'business_verification_doc';

    
    public function businessVerification()
    {
        return $this->belongsTo('App\Model\BusinessVerification' ,'bus_ver_id');
    }

    public function getPreviewDocAttribute()
	{
        $type = File::extension($this->src);
	    return $type;
	}

    public function getExtensionAttribute()
    {
        $type = File::extension($this->src);
        return $type;
    }

    public static function fileExtension($file)
    {
        $type = File::extension($file);
        return $type;
    }

    public static function siteUrlLocation($companyId = null, $businessVerificationId = null)
    {
        $siteUrlLocation = '/uploads/';        
        if($companyId){
            $siteUrlLocation .= "{$companyId}/bus_ver/";
        }
        if ($businessVerificationId) {
            $siteUrlLocation .= "{$businessVerificationId}/";
        }

        return $siteUrlLocation; 
    }

    public function getUrlAttribute()
    {
        $filePath = $this->businessVerification->id.'?src='.$this->src;
        $fileImage = self::siteUrlLocation(auth()->user()->company_id, $this->businessVerification->id) . $this->src;
        $fileType = strtolower(self::fileExtension($this->src));
        if($fileType == 'pdf'){
            return ['file' => $filePath, 'image' => $fileImage, 'type' => 'pdf'];
        }else if($fileType == 'doc'|| $fileType == 'docx'){
            return ['file' => $filePath, 'image' => asset('img/samples/sample-doc.png'), 'type' => 'doc'];
        }else if($fileType == 'xls'){
            return ['file' => $filePath, 'image' => asset('img/samples/sample-xls.png'), 'type' => 'xls'];
        }
        return ['file' => $filePath, 'image' => $fileImage, 'type' => 'image'];
    }

}
