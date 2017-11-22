<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class IdeaApiTest extends TestCase
{
    use DatabaseMigrations, DatabaseTransactions;

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
            ->assertExactJson($validResponse->toArray());
    }

    /** @test */
    public function it_fetches_all_ideas()
    {
        $validResponse = \App\Models\Idea::all()->load(['tags', 'attachments']);

        $response = $this->withHeaders($this->headers)->get('/api/v1/ideas');

        $response->assertStatus(200)
            ->assertExactJson($validResponse->toArray());
    }

    /** @test */
    public function it_creates_an_idea()
    {
        $response = $this->withHeaders($this->headers)->post('/api/v1/ideas', [
            'query' => '$ #tag Lorem Ipsum #000 http://idea.dev',
        ]);

        $response->assertStatus(201)
            ->assertJson([
                'content' => 'Lorem Ipsum',
                'color' => '#000',
                'query' => '$ #tag Lorem Ipsum #000 http://idea.dev',
                'tags' => [ ['name' => 'tag'] ],
                'attachments' => [ ['type' => \App\Models\Attachment::LINK, 'content' => 'http://idea.dev'] ]
            ]);
    }

    /** @test */
    public function it_deletes_an_idea()
    {
        $response = $this->withHeaders($this->headers)->delete('/api/v1/ideas/1');

        $response->assertStatus(204);

        $this->assertNull(\App\Models\Idea::find(1));
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

    /** @test */
    public function it_shows_405_when_method_now_allowed()
    {
        $response = $this->withHeaders($this->headers)->post('/api/v1/ideas/1', [
            'query' => '$ #tag lorem',
        ]);

        $response->assertStatus(405);
    }

    /** @test */
    public function it_shows_422_when_invalid_delimiter()
    {
        $response = $this->withHeaders($this->headers)->post('/api/v1/ideas', [
            'query' => '#tag',
        ]);

        $response->assertStatus(422);
    }

    /** @test */
    public function it_stores_ideas_with_no_content_or_color()
    {
        $response = $this->withHeaders($this->headers)->post('/api/v1/ideas', [
            'query' => '$ #tag',
        ]);

        $response->assertStatus(201);
    }

    /** @test */
    public function it_sorts_ideas_by_date_desc()
    {
        $response = $this->withHeaders($this->headers)->get('/api/v1/ideas');

        $data = json_decode($response->content());

        $this->assertEquals((int) $data[count($data) - 1]->id, 1);
        $this->assertEquals((int) $data[0]->id, count($data));
    }

    /** @test */
    public function it_sends_notification_after_creating_a_new_idea_if_supposed_to()
    {
        \Illuminate\Support\Facades\Notification::fake();

        $response = $this->withHeaders($this->headers)->post('/api/v1/ideas', [
            'query' => '$! asd #tag',
        ]);

        $response->assertStatus(201);
        \Illuminate\Support\Facades\Notification::assertSentTo(
            [new \App\Slack\ScriptyBois], \App\Notifications\IdeaCreated::class
        );
    }
}
