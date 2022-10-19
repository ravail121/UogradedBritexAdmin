<?php

namespace App\Listeners;

use Config;
use App\Company;
use Carbon\Carbon;

/**
 * Trait EmailLayout
 *
 * @package App\Listeners
 */
trait EmailLayout
{
	/**
	 * @param $emailTemplate
	 * @param $data
	 * @param $dataRow
	 *
	 * @return array
	 */
	public function makeEmailLayout($emailTemplate, $data, $dataRow)
    {
        if(filter_var($emailTemplate->to, FILTER_VALIDATE_EMAIL)){
            $email = $emailTemplate->to;
        }else{
            $email = $data->email;
        }

        $body = $this->makeEmailBody($emailTemplate, $dataRow);

        return [
            'email'  => $email,
            'body'   => $body
        ];
    }

	/**
	 * @param $companyId
	 *
	 * @return false
	 */
	public function setMailConfiguration($companyId)
    {
        $company = Company::find($companyId);
        $config = [
            'driver'        => $company->smtp_driver,
            'host'          => $company->smtp_host,
            'port'          => $company->smtp_port,
            'username'      => $company->smtp_username,
            'password'      => $company->smtp_password,
            'encryption'    => $company->smtp_encryption,
        ];

        Config::set('mail',$config);
        return false;
    }

	/**
	 * @param $fields
	 * @param $data
	 * @param $body
	 *
	 * @return string|string[]
	 */
	public function addFieldsToBody($fields, $data, $body)
    {
       return str_replace($fields, $data, $body);
    }

	/**
	 * @param $emailTemplate
	 * @param $dataRow
	 *
	 * @return string|string[]
	 */
	public function makeEmailBody($emailTemplate, $dataRow)
    {
        $names = array();
        $column = preg_match_all('/\[(.*?)\]/s', $emailTemplate->body, $names);
        $table = null;
        $replaceWith = null;

        foreach ($names[1] as $key => $name) {
            $dynamicField = explode("__",$name);
            if($table != $dynamicField[0]){
                if(isset($dataRow[$dynamicField[0]])){
                    $data = $dataRow[$dynamicField[0]]; 
                    $table = $dynamicField[0];
                }else{
                    unset($names[0][$key]);
                    continue;
                }
            }
            $replaceWith[$key] = $data->{$dynamicField[1]} ?: $names[0][$key];

        }
        $body = str_replace($names[0], $replaceWith, $emailTemplate->body);
        return $body;
    }

	/**
	 * @param $date
	 *
	 * @return string
	 */
	public function getDateFormated($date)
    {
        if($date){
            return Carbon::parse($date)->format('m/d/Y');   
        }
        return 'NA';
    }
}
