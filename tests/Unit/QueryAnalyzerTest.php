<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class QueryAnalyzerTest extends TestCase
{
    /**
     * Boots the application and sets up unit tests.
     */
    public function setUp()
    {
        parent::setUp();

        $this->app = $this->createApplication();
    }

    /** @test */
    public function it_finds_a_tag()
    {
        $analyzer = $this->app->make('analyzer');

        $analyzer->parseQuery('$ #tag');

        $this->assertEquals(
            $analyzer->tags->first(),
            '#tag'
        );
    }

    /** @test */
    public function it_finds_an_image()
    {
        $cases = [
            'https://example.com/images/test/page',
            'https://example.com/images/test.png'
        ];

        $analyzer = $this->app->make('analyzer');

        $analyzer->parseQuery('$ ' . implode(' ', $cases));

        $this->assertEquals(
            $analyzer->images->first(),
            'https://example.com/images/test.png'
        );

        $this->assertTrue($analyzer->images->count() == 1);
    }

    /** @test */
    public function it_finds_a_link()
    {
        $analyzer = $this->app->make('analyzer');

        $analyzer->parseQuery('$ https://example.com/test/page');

        $this->assertEquals(
            $analyzer->links->first(),
            'https://example.com/test/page'
        );
    }

    /** @test */
    public function it_finds_content()
    {
        $analyzer = $this->app->make('analyzer');

        $analyzer->parseQuery('$ Lorem #test ipsum.');

        $this->assertEquals(
            implode(' ', $analyzer->content->toArray()),
            'Lorem ipsum.'
        );
    }
}
