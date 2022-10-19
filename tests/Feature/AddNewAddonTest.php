<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class AddNewAddonTest extends TestCase
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

    public function testCreateAddonTest()
    {
        $this->login();
        $response = $this->post('create-addon?'.http_build_query([
            'name'                  => $this->faker->name,
            'description'           => $this->faker->paragraph,
            'taxable'               => $this->faker->boolean(),
            'amount_recurring'      => rand(0, 10),
            'show'                  => rand(0, 2)
        ]));

        $response->assertStatus(200)->assertJson([
            'id' => true,
        ]);
    }

    public function testCreateAddonWithoutAmountTest()
    {
        $this->login();
        $response = $this->post('create-addon?'.http_build_query([
            'name'                  => $this->faker->name,
            'description'           => $this->faker->paragraph,
            'taxable'               => $this->faker->boolean(),
            'show'                  => rand(0, 2)
        ]));

        $response->assertStatus(302);
    }

    public function testCreateAddonWithoutNameTest()
    {
        $this->login();
        $response = $this->post('create-addon?'.http_build_query([
            'description'           => $this->faker->paragraph,
            'taxable'               => $this->faker->boolean(),
            'amount_recurring'      => rand(0, 10),
            'show'                  => rand(0, 2)
        ]));

        $response->assertStatus(302);
    }
}
