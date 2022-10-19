<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class AddNewSimTest extends TestCase
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

    public function testCreateSimTest()
    {
        $this->login();
        $response = $this->post('create-sim?'.http_build_query([
            'name'                  => $this->faker->name,
            'carrier_id'            => '0',
            'amount_w_plan'         => rand(0, 10),
            'amount_alone'          => rand(0, 10),
            'shipping_fee'          => rand(0, 10),
            'show'                  => rand(0, 2)
        ]));

        $response->assertStatus(200)->assertJson([
            'id' => true,
        ]);
    }

    public function testCreateSimWithoutAmountTest()
    {
        $this->login();
        $response = $this->post('create-sim?'.http_build_query([
            'name'                  => $this->faker->name,
            'carrier_id'            => '0',
            'shipping_fee'          => rand(0, 10),
            'show'                  => rand(0, 2)
        ]));

        $response->assertStatus(302);
    }

    public function testCreateSimWithoutNameTest()
    {
        $this->login();
        $response = $this->post('create-sim?'.http_build_query([
            'carrier_id'            => '0',
            'amount_w_plan'         => rand(0, 10),
            'amount_alone'          => rand(0, 10),
            'shipping_fee'          => rand(0, 10),
            'show'                  => rand(0, 2)
        ]));

        $response->assertStatus(302);
    }
}
