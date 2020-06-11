<?php

namespace Tests\Feature;

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Faker\Factory;
use Illuminate\Support\Facades\DB;

class DomainsControllerTest extends TestCase
{
    use RefreshDatabase;

    private $id;
    /**
     * A basic feature test example.
     *
     * @return void
     */

    public function addDomain()
    {
        $faker = Factory::create();

        $this->id = DB::table('domains')->insertGetId(
            [
                'name' => $faker->url,
                'created_at' => $faker->dateTime()
            ]
        );
    }

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
        $this->addDomain();

        $this->assertDatabaseHas('domains', ['id' => $this->id]);
    }

    public function testShow()
    {
        $this->addDomain();

        $response = $this->get(route('domains.show', $this->id));

        $response->assertStatus(200);
    }
}
