<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class AddNewPlanTest extends TestCase
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
        $response = $this->post('add-plans?'.http_build_query([
            'name'                  => $this->faker->name,
            'carrier_id'            => '0',
            'amount_recurring'      => rand(0, 10),
            'amount_onetime'        => rand(0, 10),
            'area_code'             => $this->faker->boolean(),
            'regulatory_fee_amount' => rand(0, 10),
            'type'                  => rand(0, 10),
            'show'                  => rand(0, 2)
        ]));

        $response->assertStatus(200)->assertJson([
            'id' => true,
        ]);
    }

    public function testCreatePlanWithoutAmountTest()
    {
        $this->login();
        $response = $this->post('add-plans?'.http_build_query([
            'name'                  => $this->faker->name,
            'carrier_id'            => '0',
            'area_code'             => $this->faker->boolean(),
            'regulatory_fee_amount' => rand(0, 10),
            'type'                  => rand(0, 10),
            'show'                  => rand(0, 2)
        ]));

        $response->assertStatus(302);
    }

    public function testCreatePlanWithoutNameTest()
    {
        $this->login();
        $response = $this->post('add-plans?'.http_build_query([
            'carrier_id'            => '0',
            'amount_recurring'      => rand(0, 10),
            'amount_onetime'        => rand(0, 10),
            'area_code'             => $this->faker->boolean(),
            'regulatory_fee_amount' => rand(0, 10),
            'type'                  => rand(0, 10),
            'show'                  => rand(0, 2)
        ]));

        $response->assertStatus(302);
    }
}
