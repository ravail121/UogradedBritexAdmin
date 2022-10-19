<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use App\Exports\ExportCsv;
use App\Imports\UsersImport;
use Illuminate\Http\Request;
use Wilgucki\Csv\Facades\Writer;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Response;

/**
 * Class GoKnowController
 *
 * @package App\Http\Controllers
 */
class GoKnowController extends Controller
{

	/**
	 *
	 */
	const TARGET_STATUS = [
		'restoreLines' => 'active',
		'suspendLines' => 'suspended'
	];

	/**
	 * @return array|\Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application|\Illuminate\View\View
	 */
	public function index()
	{
		return view('go-know.index');
	}

	/**
	 * @param Request $request
	 *
	 * @return string
	 */
	public function getResponse(Request $request)
	{

		$phoneNumbers = explode("\n",$request->phone_number);
		$result = '<div class="alert alert-warning">
            <h3>Suspend Multiple Lines Response</h3>
            <table class="table table-striped">
                <tbody>
                    <tr>
                        <th width="130px">Number</th>
                        <th>Title</th>
                        <th>Message</th>
                        <th>Error</th>
                        <th>Code</th>
                        <th>Status</th>
                    </tr>';

		foreach ($phoneNumbers as $key => $number) {
			$number = trim($number);

			$response = $this->getApiResponse($number , [ 'status' => self::TARGET_STATUS [$request->target_status]]);
			if (isset($response['title'])) {
				$result .='<tr>
                    <td>'.$number.'</td>
                    <td>'.$response['title'].'</td>
                    <td>'.$response['message'].'</td>
                    <td>'.$response['error'].'</td>
                    <td>'.$response['code'].'</td>
                    <td>'.$response['status'].'</td>
                </tr>';
			}else{
				$result .='<tr>
                    <td>'.$number.'</td>
                    <td>NA</td>
                    <td>NA</td>
                    <td>NA</td>
                    <td>NA</td>
                    <td>'.$response['status'].'</td>
                </tr>';
			}
		}
		$result .='</tbody>
            </table>
        </div>';
		return $result;
	}

	/**
	 * @param Request $request
	 *
	 * @return string
	 */
	public function getRestoreResponse(Request $request)
	{

		$phoneNumbers = explode("\n",$request->phone_number);
		$result = '<div class="alert alert-info">
            <h3>Restore Multiple Lines Response</h3>
            <table class="table table-striped">
                <tbody>
                    <tr>
                        <th width="130px">Number</th>
                        <th>Title</th>
                        <th>Message</th>
                        <th>Error</th>
                        <th>Code</th>
                        <th>Status</th>
                    </tr>';

		foreach ($phoneNumbers as $key => $number) {
			$number = trim($number);

			$response = $this->getApiResponse($number , [ 'status' => self::TARGET_STATUS [$request->target_status]]);

			if (isset($response['title'])) {
				$result .='<tr>
                    <td>'.$number.'</td>
                    <td>'.$response['title'].'</td>
                    <td>'.$response['message'].'</td>
                    <td>'.$response['error'].'</td>
                    <td>'.$response['code'].'</td>
                    <td>'.$response['status'].'</td>
                </tr>';
			}else{
				$result .='<tr>
                    <td>'.$number.'</td>
                    <td>NA</td>
                    <td>NA</td>
                    <td>NA</td>
                    <td>NA</td>
                    <td>'.$response['status'].'</td>
                </tr>';
			}
		}
		$result .='</tbody>
            </table>
        </div>';
		return $result;
	}

	/**
	 * @param Request $request
	 *
	 * @return string
	 */
	public function changeSim(Request $request)
	{
		$phoneNumbers = $request->phone_number;
		$simNumbers = $request->sim_number;

		$result = '<div class="alert alert-primary">
            <h3>SWAP Sim Changes Response</h3>
            <table class="table table-striped">
                <tbody>
                    <tr>
                        <th width="130px">Number</th>
                        <th>Title</th>
                        <th>Message</th>
                        <th>Error</th>
                        <th>Code</th>
                        <th>Status</th>
                    </tr>';

		$response = null;
		foreach ($phoneNumbers as $key => $number) {
			if($number){
				$number = trim($number);
				$response = $this->getApiResponse($number , [ 'sim_number' => $simNumbers[$key]]);
				if (isset($response['title'])) {
					$result .='<tr>
                        <td>'.$number.'</td>
                        <td>'.$response['title'].'</td>
                        <td>'.$response['message'].'</td>
                        <td>'.$response['error'].'</td>
                        <td>'.$response['code'].'</td>
                        <td>'.$response['status'].'</td>
                    </tr>';
				}else{
					$result .='<tr>
                        <td>'.$number.'</td>
                        <td>NA</td>
                        <td>NA</td>
                        <td>NA</td>
                        <td>NA</td>
                        <td>'.$response['status'].'</td>
                    </tr>';
				}
			}
		}
		$result .='</tbody>
            </table>
        </div>';
		return $result;
	}

	/**
	 * @param Request $request
	 *
	 * @return string
	 */
	public function changeAreaCode(Request $request)
	{
		$phoneNumbers = $request->area_phone_number;
		$areacodes = $request->areacode;

		$result = '<div class="alert alert-info">
            <h3>Area Code Change Response</h3>
            <table class="table table-brdered">
                <tbody>
                    <tr>
                        <th>Old Number</th>
                        <th>New Phone Number</th>
                        <th>Message (error)</th>
                    </tr>';

		$response = null;
		foreach ($phoneNumbers as $key => $number) {
			if($number){
				$number = trim($number);
				$response =  $this->getApiResponse($number , [ 'area_code' => $areacodes[$key]]);
				if (isset($response['phone_number'])) {
					$result .='<tr>
                        <td>'.$number.'</td>
                        <td>'.$response['phone_number'].'</td>
                        <td>'.$response['message'].'</td>
                    </tr>';
				}else{
					$result .='<tr>
                        <td>'.$number.'</td>
                        <td>NA</td>
                        <td>'.$response['message'].'</td>
                    </tr>';
				}
			}
		}
		$result .='</tbody>
            </table>
        </div>';
		return $result;
	}

	/**
	 * @param Request  $request
	 * @param Response $response
	 *
	 * @return string
	 */
	public function uploadCsv(Request $request, Response $response)
	{
		$file = fopen($request->csv_file, 'r');
		$data = [];
		while (($line = fgetcsv($file)) !== FALSE) {
			$data[] = $line;
		}
		$response = null;
		fclose($file);
		if($request->type == 'changesim'){
			$result = '<div class="alert alert-primary">
            <h3>SWAP Sim Changes Response</h3>
            <table class="table table-striped">
                <tbody>
                    <tr>
                        <th width="130px">Number</th>
                        <th>Title</th>
                        <th>Message</th>
                        <th>Error</th>
                        <th>Code</th>
                        <th>Status</th>
                    </tr>';

			foreach ($data as $key => $value) {
				if(isset($value[0]) && isset($value[1])){
					$response =  $this->getApiResponse($value[0] , [ 'sim_number' => $value[1]]);
					if (isset($response['title'])) {
						$result .='<tr>
                            <td>'.$value[0].'</td>
                            <td>'.$response['title'].'</td>
                            <td>'.$response['message'].'</td>
                            <td>'.$response['error'].'</td>
                            <td>'.$response['code'].'</td>
                            <td>'.$response['status'].'</td>
                        </tr>';
					}else{
						$result .='<tr>
                            <td>'.$value[0].'</td>
                            <td>NA</td>
                            <td>NA</td>
                            <td>NA</td>
                            <td>NA</td>
                            <td>'.$response['status'].'</td>
                        </tr>';
					}
				}else{
					return "INVALID FILE FORMAT";
				}
			}
		}else if($request->type == 'areacode'){
			$result = '<div class="alert alert-info">
            <h3>Area Code Change Response</h3>
            <table class="table table-brdered">
                <tbody>
                    <tr>
                        <th>Old Number</th>
                        <th>New Phone Number</th>
                        <th>Message (error)</th>
                    </tr>';
			foreach ($data as $key => $value) {
				if(isset($value[0]) && isset($value[1])){
					$response =  $this->getApiResponse($value[0] , [ 'area_code' => $value[1]]);

					if (isset($response['phone_number'])) {
						$result .='<tr>
                            <td>'.$value[0].'</td>
                            <td>'.$response['phone_number'].'</td>
                            <td>'.$response['message'].'</td>
                        </tr>';
					}else{
						$result .='<tr>
                            <td>'.$value[0].'</td>
                            <td>NA</td>
                            <td>'.$response['message'].'</td>
                        </tr>';
					}
				}else{
					return "INVALID FILE FORMAT";
				}
			}
		}
		$result .='</tbody>
            </table>
        </div>';
		return $result;
	}

	/**
	 * @param Request  $request
	 * @param Response $response
	 *
	 * @return \Illuminate\Http\RedirectResponse|\Symfony\Component\HttpFoundation\BinaryFileResponse
	 */
	public function csvReport(Request $request, Response $response)
	{
		$response = $this->getCsvReport();
		if($request->reports_in_csv == 'specific_numbers'){
			$phoneNumbers = explode("\n",$request->specific_numbers);
			$phoneNumbers = array_map('trim', $phoneNumbers);
			$response = $response->whereIn('phone_number', $phoneNumbers);
		}else if($request->reports_in_csv == 'specific_sims'){
			$simNumber = explode("\n",$request->specific_sims);
			$simNumber = array_map('trim', $simNumber);
			$response = $response->whereIn('sim_number', $simNumber);
		}

		$response->prepend(["phone_number" => "phone_number",
		                    "sim_number" => 'sim_number',
		                    "ban" => "ban",
		                    "status" => "status",
		                    "transaction_id" => 'transaction_id',
		                    "mno" => "mno"], 'zero');

		$data = [];
		foreach ($response->toArray() as $line) {
			$data[] = $line;
		}
		if (count($data)) {
			$path = public_path().'/temp/';
			$randomFileName = md5(rand(1,99)).'.csv';
			$writer = Writer::create($path.$randomFileName);
			$writer->writeAll($data);
			return response()->download($path.$randomFileName, 'data.csv')->deleteFileAfterSend(true);
		} else {
			return redirect()->back()->with('errors', 'No data found');
		}
	}

	/**
	 * @return \Illuminate\Support\Collection|mixed|null
	 * @throws \GuzzleHttp\Exception\GuzzleException
	 */
	public function getCsvReport()
	{
		$client = new Client([
			'headers' => [
				'X-API-KEY' => auth()->user()->company->goknows_api_key,
			]
		]);

		$errorMessage = null;
		try {
			$response = $client->request('GET', env('GO_KNOW_URL'));
			if ($response->getStatusCode() == 200) {
				return collect(json_decode($response->getBody(), true));
			}
		} catch (\Exception $e) {
			$responseBody = json_decode($e->getResponse()->getBody(true), true);
			$errorMessage = $responseBody['message'];
		}
		return $errorMessage;
	}

	/**
	 * @param $phoneNumber
	 * @param $parameter
	 *
	 * @return \Illuminate\Support\Collection
	 * @throws \GuzzleHttp\Exception\GuzzleException
	 */
	protected function getApiResponse($phoneNumber, $parameter )
	{
		$client = new Client([
			'headers' => [
				'X-API-KEY' => auth()->user()->company->goknows_api_key,
			]
		]);

		$errorMessage = null;
		try {
			$response = $client->request('PUT', env('GO_KNOW_URL').$phoneNumber, [
				'form_params' => $parameter
			]);
			if ($response->getStatusCode() == 200) {
				$responseBody = collect(json_decode($response->getBody(), true));
			}
		} catch (\Exception $e) {
			$responseBody = collect(json_decode($e->getResponse()->getBody(true), true));
		}
		return $responseBody;
	}
}
