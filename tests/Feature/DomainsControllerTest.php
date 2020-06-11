<?php

namespace Tests\Feature;

use Tests\TestCase;
use Faker\Factory;

class DomainsControllerTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */

    public function testIndex()
    {
        $response = $this->get(route('domains.index'));

        $response->assertStatus(200);
    }

    public function testCreate()
    {
        $response = $this->get(route('domains.create'));

        $response->assertStatus(200);
    }

    public function testStore()
    {
        $faker = Factory::create();

        $data = [
            'name' => $faker->url,
            'created_at' => $faker->dateTime()
        ];

        $response = $this->post(route('domains.store'), $data);
        $response->assertSessionHasNoErrors();
        $response->assertRedirect();
    }
}
