<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class IdeaApiTest extends TestCase
{
    use DatabaseMigrations;

    public function setUp()
    {
        parent::setUp();

        $this->artisan('db:seed');

        $this->user = \App\Models\User::find(1);
        $this->headers = [
            'Authorization' => 'Bearer ' . $this->user->api_token,
            'Accept' => 'application/json',
        ];
    }

    /** @test */
    public function it_fetches_a_single_idea()
    {
        $validResponse = \App\Models\Idea::find(1)->load(['tags', 'attachments']);

        $response = $this->withHeaders($this->headers)->get('/api/v1/ideas/1');

        $response->assertStatus(200)
            ->assertJson($validResponse->toArray());
    }

    /** @test */
    public function it_fetches_all_ideas()
    {
        $validResponse = \App\Models\Idea::all()->load(['tags', 'attachments']);

        $response = $this->withHeaders($this->headers)->get('/api/v1/ideas');

        $response->assertStatus(200)
            ->assertJson($validResponse->toArray());
    }

    /** @test */
    public function it_deletes_an_idea()
    {
        $response = $this->withHeaders($this->headers)->delete('/api/v1/ideas/1');

        $response->assertStatus(204);
    }

    /** @test */
    public function it_shows_404_when_requesting_non_existing_idea()
    {
        $response = $this->withHeaders($this->headers)->get('/api/v1/ideas/asd');

        $response->assertStatus(404);

        $response = $this->withHeaders($this->headers)->delete('/api/v1/ideas/asd');

        $response->assertStatus(404);

        $response = $this->withHeaders($this->headers)->put('/api/v1/ideas/asd', ['query' => 'lorem']);

        $response->assertStatus(404);
    }

    /** @test */
    public function it_shows_401_when_not_authorized_to_create_idea()
    {
        $response = $this->withHeaders([
            'Accept' => 'application/json'
        ])->post('/api/v1/ideas', ['query' => 'lorem']);

        $response->assertStatus(401);

        $response = $this->withHeaders([
            'Accept' => 'application/json'
        ])->put('/api/v1/ideas/1', ['query' => 'lorem']);

        $response->assertStatus(401);
    }

    /** @test */
    public function it_shows_422_when_query_string_is_missing()
    {
        $response = $this->withHeaders($this->headers)->post('/api/v1/ideas');

        $response->assertStatus(422);

        $response = $this->withHeaders($this->headers)->put('/api/v1/ideas/1');

        $response->assertStatus(422);
    }
}
