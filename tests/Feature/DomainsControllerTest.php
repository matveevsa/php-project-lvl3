<?php

namespace Tests\Feature;

use Tests\TestCase;
use Faker\Factory;
use Illuminate\Support\Facades\DB;

class DomainsControllerTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $faker = Factory::create();

        DB::table('domains')->insert([
            'name' => $faker->url,
            'created_at' => $faker->dateTime()
        ]);
    }

    public function testIndex()
    {
        $response = $this->get(route('domains.index'));

        $response->assertOk();
    }

    public function testCreate()
    {
        $response = $this->get(route('domains.create'));

        $response->assertOk();
    }

    public function testStore()
    {
        $faker = Factory::create();

        $id = DB::table('domains')->insertGetId([
            'name' => $faker->url,
            'created_at' => $faker->dateTime()
        ]);

        $response = $this->post(route('domains.store'));
        $response->assertSessionHasNoErrors();
        $response->assertRedirect();

        $this->assertDatabaseHas('domains', ['id' => $id]);
    }

    public function testShow()
    {
        $faker = Factory::create();

        $id = DB::table('domains')->insertGetId([
            'name' => $faker->url,
            'created_at' => $faker->dateTime()
        ]);

        $response = $this->get(route('domains.show', $id));

        $response->assertOk();
    }
}
