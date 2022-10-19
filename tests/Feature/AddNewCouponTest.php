<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class AddNewCouponTest extends TestCase
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

    public function testCreateCouponTest()
    {
        $this->login();
        $response = $this->post('add-coupon?'.http_build_query([
            'name'                       => $this->faker->name,
            'type'                       => '',
            'sub_type'                   => '0',
            'product_type'               => '',
            'multiline_max'              => rand(0, 50),
            'multiline_min'              => rand(0, 2),
            'class'                      => rand(1, 3),
            'fixed_or_perc'              => rand(0, 10),
            'amount'                     => rand(0, 10),
            'code'                       => $this->faker->name,
            'num_cycles'                 => rand(0, 50),
            'max_uses'                   => rand(0, 50),
            'num_uses'                   => rand(0, 50),
            'stackable'                  => $this->faker->boolean(),
            'start_date'                 => $this->faker->date(),
            'end_date'                   => $this->faker->date(),
        ]));

        $response->assertStatus(200)->assertJson([
            'id' => true,
        ]);
    }

    public function testCreateCouponWithoutAmountTest()
    {
        $this->login();
        $response = $this->post('add-coupon?'.http_build_query([
            'name'                       => $this->faker->name,
            'type'                       => '',
            'sub_type'                   => '0',
            'product_type'               => '',
            'multiline_max'              => rand(0, 50),
            'multiline_min'              => rand(0, 2),
            'class'                      => rand(1, 3),
            'fixed_or_perc'              => rand(0, 10),
            'code'                       => $this->faker->name,
            'num_cycles'                 => rand(0, 50),
            'max_uses'                   => rand(0, 50),
            'num_uses'                   => rand(0, 50),
            'stackable'                  => $this->faker->boolean(),
            'start_date'                 => $this->faker->date(),
            'end_date'                   => $this->faker->date(),
        ]));

        $response->assertStatus(302);
    }
}
