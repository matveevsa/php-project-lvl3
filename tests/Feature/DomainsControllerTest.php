<?php

namespace Tests\Feature;

use Tests\TestCase;
use Faker\Factory;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DomainsControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */

    public $id;

    protected function setUp(): void
    {
        parent::setUp();
        $faker = Factory::create();

        $this->id = DB::table('domains')->insertGetId([
            'name' => parse_url($faker->url, PHP_URL_HOST),
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
        $response = $this->post(route('domains.store'));
        $response->assertSessionHasNoErrors();
        $response->assertRedirect();

        $this->assertDatabaseHas('domains', ['id' => $this->id]);
    }

    public function testShow()
    {
        $response = $this->get(route('domains.show', $this->id));

        $response->assertOk();
    }
}
