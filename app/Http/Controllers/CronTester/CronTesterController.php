<?php

namespace App\Http\Controllers\CronTester;

use SSH;
use Auth;
use Exception;
use DataTables;
use Carbon\Carbon;
use App\Model\Order;
use App\Model\Invoice;
use App\Model\CronLog;
use App\Model\Customer;
use App\Model\PaymentLog;
use App\Model\Subscription;
use Illuminate\Http\Request;
use App\Model\BusinessVerification;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class CronTesterController extends Controller
{
    public function index()
    {
//        if (!env('CRON_TESTING')) {
//            return redirect()->back();
//        }
//        $this->authorise();
        return view('cron-logs.index');
    }

    public function getLogs()
    {                                                   

        $orders         =  Order::whereDate('created_at', '=', date('Y-m-d'))->get();
        $invoices       =  Invoice::whereDate('created_at', '=', date('Y-m-d'))->get();
        $paymentLog     =  PaymentLog::whereDate('created_at', '=', date('Y-m-d'))->get();
        $business       =  BusinessVerification::whereDate('created_at', '=', date('Y-m-d'))->get();
        $subscription   =  Subscription::whereDate('created_at', '=', date('Y-m-d'))->get();
        $date           =  Carbon::now()->format('d/m/y');
        $time           =  Carbon::now()->format('h:i:s');

        $invoiceIds     = $invoices->pluck('id');
        $invoicePdf     = [];
        //pdf
        foreach ($invoiceIds as $id) {
            $invoice        = Invoice::find($id);
            if ($invoice->order) {
                $invoicePdf[]   = '<a href='.config('internal.__BRITEX_API_BASE_URL').'/invoice/download/'.auth()->user()->company_id.'?order_hash='.$invoice->order["hash"].'>Here</a>';
            } else {
                $invoicePdf[]   = '<a href='.config('internal.__BRITEX_API_BASE_URL').'/invoice/download/'.auth()->user()->company_id.'?invoice_hash='.bin2hex($invoice->id).'>Here</a>';
            }
        }
        $data = [
            'orders'        => $orders,
            'invoice'       => $invoices,
            'invoicePdf'    => $invoicePdf,
            'paymentLog'    => $paymentLog,
            'business'      => $business,
            'subscription'  => $subscription,
            'date'          => $date,
            'time'          => $time,
        ];

        return env('CRON_TESTING') ? $data : redirect()->back();

    }

//	public function getCronLogs(Request $request)
//	{
//		$date = $request->date;
//		if($date == 0){
//			$data = CronLog::all();
//
//		}else{
//			$data = CronLog::where(['ran_at', '>', Carbon::now()->subDays($date)->endOfDay()])
//				->get();
//		}
//		return DataTables::of($data)
//             ->addColumn('name', function(CronLog $detail) {
//	             return $detail->name;
//             })
//             ->addColumn('status', function(CronLog $detail) {
//                 return $detail->status;
//             })
//             ->addColumn('response', function(CronLog $detail) {
//				return $detail->response;
//			})
//			->addColumn('ran_at', function(CronLog $detail) {
//				return $detail->getRanAtDateFormattedAttribute();
//			})
//             ->addColumn('id', function(CronLog $detail) {
//                 return $detail->id;
//             })
//             ->rawColumns(['name', 'status', 'response', 'ran_at'])
//             ->make(true);
//	}

    public function getDate()
    {
        $date = Carbon::today(env('SERVER_TIMEZONE'));
        $time = Carbon::now(env('SERVER_TIMEZONE'));
        
        $data = [
            'date' => Carbon::parse($date)->format('m/d/Y'), 
            'time' => Carbon::parse($time)->format('H:i:s'),
            'date_time' => Carbon::parse($time)->format('Y-m-d H:i:s')
        ];

        return $data;
        
    }

    public function setDate(Request $request)
    {
        if (env('CRON_TESTING')) {
            $date = $request->input('date');

            $changeDate = [
                'cd '.env('API_DIRECTORY'),
                'echo '.env('SERVER_PASSWORD').' | sudo -S timedatectl set-ntp 0',
                'echo '.env('SERVER_PASSWORD').' | sudo -S date --set="'.$date.'"',
            ];

            SSH::run($changeDate, function($line) {
                echo $line.PHP_EOL;
            });
                
            return $date;
        }
        
    }

    public function resetDate()
    {
        $resetDate = [
            'cd '.env('API_DIRECTORY'),
            'echo '.env('SERVER_PASSWORD').' | sudo -S timedatectl set-ntp 1',
        ];

        SSH::run($resetDate, function($line) {
            echo $line.PHP_EOL;
        });
        
        return $this->getDate();

    }
    
    public function restartApache()
    {
        $restartServer = [
            'ssh -t',
            'echo '.env('SERVER_PASSWORD').' | sudo service apache2 restart',
        ];
        
        SSH::run($restartServer, function() {
            echo 'Apache Restarted';
        });
    }

    public function restartPhp()
    {
        $restartServer = [
            'ssh -t',
            'echo '.env('SERVER_PASSWORD').' | sudo service php'.env('PHP_VERSION').'-fpm restart',
        ];
        
        SSH::run($restartServer, function() {
            echo 'Php restarted';
        });
    }   
    
    public function cleanCache()
    {
        $restartServer = [
            'cd '.env('API_DIRECTORY'),
            'php artisan config:cache',
            'php artisan cache:clear',
            'php artisan config:clear',
            'cd',
        ];
        
        SSH::run($restartServer, function($line) {
            echo $line.PHP_EOL;    
        });
    }

    private function authorise()
    {
        $username = null;
        $password = null;

        // mod_php
        if (isset($_SERVER['PHP_AUTH_USER'])) {
            $username = $_SERVER['PHP_AUTH_USER'];
            $password = $_SERVER['PHP_AUTH_PW'];

        // most other servers
        } elseif (isset($_SERVER['HTTP_AUTHORIZATION'])) {
            if (strpos(strtolower($_SERVER['HTTP_AUTHORIZATION']),'basic')===0)
              list($username,$password) = explode(':',base64_decode(substr($_SERVER['HTTP_AUTHORIZATION'], 6)));

        }

        if ($username != 'admin@britex.pw' && $password != 'qwerty') {
            header('WWW-Authenticate: Basic realm="My Realm"');
            header('HTTP/1.0 401 Unauthorized');
            echo '<h1>Unauthorized Access</h1>';
            die();

        } else {
            /*echo "<p>Hello {$username}.</p>";
            echo "<p>You entered {$password} as your password.</p>";*/
        }
    }

    public function prepareDelete()
    {
        $customers = Customer::all();
        return [
            'database_name' => env('DB_DATABASE'),
            'total_users'   => $customers->count(),
            'company_id'    => auth()->user()->company_id
        ];
    }

    public function clearUserData(Request $request)
    {

        $companyId  = auth()->user()->company_id;
        
        $tablesWithoutConditions = [
            'invoice_item',
            'credit_to_invoice',
            'invoice',
            'order_coupon_product',
            'order_coupon',
            'coupon_product_type',
            'coupon_product',
            'coupon_multiline_plan_type',
            'customer_coupon',
            'subscription_coupon',
            'coupon',
            'customer_credit_card',
            'credit',
            'customer_note',
            'customer_standalone_device',
            'customer_standalone_sim',
            'customer',
            'order_group',
            'order_group_addon',
            'order',
            'subscription_addon',
            'port',
            'subscription',
            'business_verification_doc',
            'business_verification',
            'password_reset',
            'payment_log',
            'pending_charge',
            'payment_refund_log',
            'email_log'
        ];
        
        try {

            DB::statement('SET FOREIGN_KEY_CHECKS = 0');

            foreach ($tablesWithoutConditions as $table) {
                DB::table($table)->truncate();
            }

            DB::table('company')->where('id', '!=', $companyId)->delete();
            DB::statement('SET FOREIGN_KEY_CHECKS = 1');

        } catch (Exception $e) {

            \Log::info($e->getMessage());
            return [
                'error' => [
                    'message'   => 'Something went wrong',
                    'code'      => $e->getCode()
                ]
            ];

        }

        return ['success' => 'Data Deleted'];
    }

    public function gitPull()
    {
        $command = [
            'cd '.env('PATH_PROJECT').' && git pull',
            'sudo systemctl restart nginx && sudo service apache2 restart && sudo service php7.0-fpm restart && php artisan config:cache && php artisan cache:clear && php artisan config:clear && php artisan view:clear && php artisan route:clear'
        ];

        SSH::run($command, function($line) {
            echo $line.PHP_EOL;
        });
    }
    
}
