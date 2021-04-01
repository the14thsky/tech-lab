<?php

namespace Tests\Feature;

use Tests\TestCase;

class KeyValueTest extends TestCase
{
	public function testKeyValue()
    {
        $response = $this->get('/');
        $response->assertStatus(200);

		$headers = ['Accept' => 'application/json'];
		$body = [
			'chair_slug' => 'omega',
			'chair_name' => 'Omega',
			'body' => '{"price": 389, "currency": "SGD"}'
		];
		$response = $this->json('POST','/api/chair',$body,$headers);
		$body = json_decode($response->getContent(),true);
		$response->assertSuccessful();

		$timestamp = &$this->getSharedVar();
		$timestamp = strtotime($body['data']['created_at']) + 1;
    }

    public function testGetChairKey()
	{
		$response = $this->get('/api/chair/omega/price');
		$response->assertSuccessful()
			->assertJson(['status' => 'ok', 'code' => 200, 'data' => 389, 'message' => 'data_received']);
	}

	public function testUpdateChair()
	{
		sleep(3);
		$headers = ['Accept' => 'application/json'];
		$body = [
			'chair_slug' => 'omega',
			'chair_name' => 'Omega',
			'body' => '{"price": 499, "currency": "SGD"}'
		];
		$response = $this->json('POST','/api/chair',$body,$headers);
		$response->assertSuccessful();
	}

	public function testGetChairKey2()
	{
		$response = $this->get('/api/chair/omega/price');
		$response->assertSuccessful()
			->assertJson(['status' => 'ok', 'code' => 200, 'data' => 499, 'message' => 'data_received']);
	}

	public function testGetChairKeyBasedOnTimestamp()
	{
		$timestamp = &$this->getSharedVar();
		$response = $this->get('/api/chair/omega/price?timestamp='.$timestamp);
		$response->assertSuccessful()
			->assertJson(['status' => 'ok', 'code' => 200, 'data' => 389, 'message' => 'data_received']);
	}

	public function testGetChairAllRecords()
	{
		$response = $this->get('/api/chair/omega/get-all-records');
		$response->assertSuccessful()
			->assertJson(['status' => 'ok', 'code' => 200, 'data' => ['price' => 499, 'currency' => 'SGD'], 'message' => 'data_received']);

	}

	protected function &getSharedVar()
	{
		static $value = null;
		return $value;
	}
}
