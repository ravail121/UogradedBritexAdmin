<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class AddNewDeviceTest extends TestCase
{
    use WithFaker;
    use DatabaseTransactions;

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testExample()
    {
        $this->assertTrue(true);
    }

    public function testCreatePlanTest()
    {
        $this->login();
        $response = $this->post('add-devices?'.http_build_query([
            'name'                  => $this->faker->name,
            'type'                  => rand(0, 10),
            'carrier_id'            => '0',
            'amount_w_plan'         => rand(0, 10),
            'amount'                => rand(0, 10),
            'shipping_fee'          => rand(0, 10),
            'show'                  => rand(0, 2)
        ]));

        $response->assertStatus(200)->assertJson([
            'id' => true,
        ]);
    }

    public function testCreatePlanWithoutAmountTest()
    {
        $this->login();
        $response = $this->post('add-devices?'.http_build_query([
            'name'                  => $this->faker->name,
            'type'                  => rand(0, 10),
            'carrier_id'            => '0',
            'shipping_fee'          => rand(0, 10),
            'show'                  => rand(0, 2)
        ]));

        $response->assertStatus(302);
    }

    public function testCreatePlanWithoutNameTest()
    {
        $this->login();
        $response = $this->post('add-devices?'.http_build_query([
            'type'                  => rand(0, 10),
            'carrier_id'            => '0',
            'amount_w_plan'         => rand(0, 10),
            'amount'                => rand(0, 10),
            'shipping_fee'          => rand(0, 10),
            'show'                  => rand(0, 2)
        ]));

        $response->assertStatus(302);
    }

    public function testCreatePlanWithStringAmountTest()
    {
        $this->login();
        $response = $this->post('add-devices?'.http_build_query([
            'name'                  => $this->faker->name,
            'type'                  => rand(0, 10),
            'carrier_id'            => '0',
            'amount_w_plan'         => "amount",
            'amount'                => "amount",
            'shipping_fee'          => rand(0, 10),
            'show'                  => rand(0, 2)
        ]));

        $response->assertStatus(302);
    }
}
