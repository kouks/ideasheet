<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class QueryAnalyzerTest extends TestCase
{
    /** @test */
    public function it_finds_a_tag()
    {
        $app = $this->createApplication();

        $analyzer = $app->make('analyzer');

        $analyzer->parseQuery('$ #tag');

        $this->assertEquals(
            $analyzer->tags->first(),
            '#tag'
        );
    }
}
