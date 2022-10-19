<?php

namespace App\Http\Controllers\ActionQueue;

use Carbon\Carbon;

trait DateHtml
{
    private function color($days)
    {
        $color =  [
            '0' => 'green',
            '1' => 'hblue',
            '2' => 'pink',
            '3' => 'purple',
            '4' => 'yllow',
        ];

        return $color[$days];
    }

    private function days($day)
    {
        $days = [
            '0' => 'Today',
            '1' => 'Yesterday',
            '2' => '2 Days',
            '3' => '3 Days',
            '4' => '4 Days',
        ];

        return $days[$day];
    }

    public function carrierImage($carrier_id)
    {
        $image = [
            ''  => 'img/default.png',
            '0'  => 'img/default.png',
            '1' => 'theme/img/t_img.png',
            '2' => 'img/at&t.png',
            '3' => 'img/sprint.png',
        ];
        if(isset($image[$carrier_id])){
            return $image[$carrier_id];
        }
        return $image['0'];
    }

    public function date($date)
    {
        $now = Carbon::now()->endOfDay();
        $sec = $now->diffInSeconds($date);
        $days = $now->diffInDays($date);
        return [ $this->getDateColor($days), $sec ];
    }

    public function getDateColor($days)
    {
        if($days > 4){
            $day = $days." days";
            $color = "z red";
            return compact('day','color');
        }else{
            $color = $this->color($days);
            $day = $this->days($days);
            return compact('day','color'); 
        }
        
    }

    public function dateHtml($days)
    {
        return  '<div class="tooltipbx float-left" data-date='.$days[1].'>
                    <a class="tooltipbase" data-toggle="tooltip"><span class="onlinecicle '.$days[0]['color'].'"></span>
                    </a>
                    <div class="tooltip bs-tooltip-top" role="tooltip">
                        <div class="arrow"></div>
                        <div class="tooltip-inner"> <span class="onlinecicle '.$days[0]['color'].'"></span> '.$days[0]['day'].' </div>
                    </div>
                </div>';
    }

    public function nameHtml($detail)
    {
        return'<div class="tableuserbx">
            <div class="usrimg data-table-image">
                <img src='.asset($this->carrierImage($detail->plans["carrier_id"])).' alt="" width="25" height="25">
            </div>
            <div class="usrname data-table-name">
                <a href = '.route("customers.detail", $detail->customer["id"]).'>
                <strong>'.$detail->customer['full_name'].'</strong>
                </a>
            </div>
        </div>';
    }

    public function shippingName($detail)
    {
        if($detail->plan_id){
            $carrierId = $detail->plans["carrier_id"];
        }else if($detail->device_id){
            $carrierId = $detail->device["carrier_id"];
        }else{
            $carrierId = $detail->sim["carrier_id"];
        }
        
        return'<div class="tableuserbx">
            <div class="usrimg data-table-image">
                <img src='.asset($this->carrierImage($carrierId)).' alt="" width="25" height="25">
            </div>
            <div class="usrname data-table-name">
                <a href = '.route("customers.detail", $detail->customer["id"]).'>
                <strong>'.$detail->customer['full_name'].'</strong>
                </a>
            </div>
        </div>';
    }

	public function dateFormated($date)
	{
		if($date){
			return Carbon::parse($date)->format('F d, Y');
		}
		return 'NA';
	}
}
