<?php

namespace App\Http\ViewComposer;

use App\Company;
use App\Model\Order;
use Illuminate\View\View;
use App\Services\Cart\CartResponse;

class EmailComposer 
{    
    public function compose(View $view)
    {
    	$view->with('companyDetail', auth()->user()->company ?? null);
    }
    
}