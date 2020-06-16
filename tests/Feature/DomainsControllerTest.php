<?php

namespace Tests\Feature;

use Tests\TestCase;
use Faker\Factory;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;

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

        $urlParsed = parse_url($faker->url);

        $domainScheme = strtolower($urlParsed['scheme']);
        $domainHost = strtolower($urlParsed['host']);

        $domainNormalizedName = "{$domainScheme}://{$domainHost}";
        $domain = [
            'name' => $domainNormalizedName,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ];

        $this->id = DB::table('domains')->insertGetId($domain);
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

    public function testChecks()
    {
        Http::fake(function () {
            $body = '<h1>Hello, from test!</h1>
            <meta name="description" content="The most popular HTML, CSS, and JS library in the world.">
            <meta name="keywords" content="HTML, CSS, JS, library">';

            return Http::response($body, 200);
        });

        $domain = DB::table('domains')->find($this->id);

        $response = $this->post(route('domains.checks', $domain->id));
        $response->assertSessionHasNoErrors();
        $response->assertRedirect();

        $this->assertDatabaseHas('domain_checks', ['domain_id' => $domain->id]);
    }
}
