<?php

namespace App\Support\Utilities;

use Exception;
use App\Company;
use GuzzleHttp\Client;

trait ApiConnect
{
	/**
	 * @param null   $url         Url of the api
	 * @param string $type        GET, POST, PUT, PATCH
	 * @param null   $parameters  form-data, parameters
	 *
	 * @return \Illuminate\Support\Collection|string
	 */
	public function requestConnection($url = null, $type = "get", $parameters = null)
	{
		$client = $this->getClientInstance();
		$apiBaseUrl = config('internal.__BRITEX_API_BASE_URL');
		try {
			if ($type == 'get') {

				$response = $client->get($apiBaseUrl.'/'.$url, [
					'query' => $parameters,
					'allow_redirects' => [
						'max' => 10,
					],
					'verify' => false
				]);

			} elseif ($type == 'put') {
				$response = $client->put($apiBaseUrl.'/'.$url, [
					'form_params'   => $parameters,
					'verify'        => false
				]);

			} elseif ($type == 'post') {

				$response = $client->post($apiBaseUrl.'/'.$url, [
					'form_params'   => $parameters,
					'verify'        => false
				]);

			} elseif ($type == 'postWithFile') {

				$response = $client->post($apiBaseUrl.'/'.$url, [
					'multipart' => $parameters,
					'verify'    => false
				]);

			} elseif ($type == 'patch') {
				$response = $client->patch($apiBaseUrl.'/'.$url, [
					'verify' => false
				]);

			}

			$status = $response->getStatusCode();
			if ($status == 200) {
				return collect(json_decode($response->getBody(), true));
			} else {
				throw new \Exception('Failed');
			}

		}  catch (Exception $exception) {
			\Log::info($exception->getMessage());
			return $exception->getMessage();
		}

	}

	/**
	 * Sets header and instantiates Client
	 *
	 * @return Client  $object
	 */
	protected function getClientInstance()
	{
		$apiKey = Company::find(auth()->user()->company_id)->api_key;
		$headers = [
			'Content-Type'  => 'application/json',
			'AccessToken'   => 'key',
			'Authorization' => $apiKey,
		];

		$object = new Client([
			'headers' => $headers
		]);
		return $object;
	}
}