<?php

namespace Tests\Feature;

use Tests\TestCase;
use Faker\Factory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;

class DomainChecksControllerTest extends TestCase
{

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

    public function testStore()
    {
        Http::fake(function () {
            $body = '<h1>Hello, from test!</h1>
            <meta name="description" content="The most popular HTML, CSS, and JS library in the world.">
            <meta name="keywords" content="HTML, CSS, JS, library">';

            return Http::response($body, 200);
        });

        $domain = DB::table('domains')->find($this->id);

        $response = $this->post(route('domainChecks.store', $domain->id));
        $response->assertSessionHasNoErrors();
        $response->assertRedirect();

        $this->assertDatabaseHas('domain_checks', ['domain_id' => $domain->id]);
    }
}
