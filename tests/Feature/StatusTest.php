<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class StatusTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testExample()
    {
        $this->assertTrue(true);
    }

    public function testMainPageTest()
    {
        $response = $this->get('/');
        $response->assertStatus(200);
    }

    public function testLoginTest()
    {
        $this->login();

        $result = $this->get('/biz-verification');
        $result->assertStatus(200);

        $emailTemplateResponse = $this->get('/email-template');
        $result->assertStatus(200);

        $couponResponse = $this->get('/coupon');
        $couponResponse->assertStatus(200);

        $allPlansResponse = $this->get('/all-plans');
        $allPlansResponse->assertStatus(200);

        $allAddonsResponse = $this->get('/all-addons');
        $allAddonsResponse->assertStatus(200);

        $allDevicesResponse = $this->get('/all-devices');
        $allDevicesResponse->assertStatus(200);

        $allSimResponse = $this->get('/all-sims');
        $allSimResponse->assertStatus(200);

        $supportResponse = $this->get('/support');
        $supportResponse->assertStatus(200);

        $actionQueueResponse = $this->get('/action-queue');
        $actionQueueResponse->assertStatus(200);

        $customersResponse = $this->get('/customers/111');
        $customersResponse->assertStatus(200);

        $banResponse = $this->get('/ban');
        $banResponse->assertStatus(200);

        $staffResponse = $this->get('/staff');
        $staffResponse->assertStatus(200);
    }
}
