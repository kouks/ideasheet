<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Contracts\Query\Analyzer;

class ParserTest extends TestCase
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
        $parser = new \App\Query\Parsers\TagParser;

        $parts = $parser->filterParts(collect(['#tag']));

        $this->assertEquals(
            $parts->first(),
            '#tag'
        );
    }

    /** @test */
    public function it_finds_all_tags()
    {
        $parser = new \App\Query\Parsers\TagParser;

        $parts = $parser->filterParts(collect(['#tag', '#tag2', 'lorem']));

        $this->assertCount(2, $parts);
    }

    /** @test */
    public function it_finds_a_3_digit_color()
    {
        $parser = new \App\Query\Parsers\ColorParser;

        $parts = $parser->filterParts(collect(['#tag', '#fd2', 'lorem']));

        $this->assertEquals(
            $parts->first(),
            '#fd2'
        );
    }

    /** @test */
    public function it_finds_a_6_digit_color()
    {
        $parser = new \App\Query\Parsers\ColorParser;

        $parts = $parser->filterParts(collect(['#tag', '#b23432', 'lorem']));

        $this->assertEquals(
            $parts->first(),
            '#b23432'
        );
    }

    /** @test */
    public function it_finds_an_image()
    {
        $parser = new \App\Query\Parsers\ImageParser;

        $parts = $parser->filterParts(collect([
            'https://example.com/images/test/page',
            'https://example.com/images/test.png',
            '#tag',
            'lorem',
        ]));

        $this->assertEquals(
            $parts->first(),
            'https://example.com/images/test.png'
        );

        $this->assertCount(1, $parts);
    }

    /** @test */
    public function it_finds_a_link()
    {
        $parser = new \App\Query\Parsers\LinkParser;

        $parts = $parser->filterParts(collect([
            'https://example.com/test/page',
            '#tag',
            'lorem',
        ]));

        $this->assertEquals(
            $parts->first(),
            'https://example.com/test/page'
        );
    }

    /** @test */
    public function it_finds_content()
    {
        $parser = new \App\Query\Parsers\ContentParser;

        $parts = $parser->filterParts(collect([
            'Lorem',
            'ipsum.',
        ]));

        $this->assertEquals(
            $parts->implode(' '),
            'Lorem ipsum.'
        );
    }

    /** @test */
    public function it_finds_a_code_snippet()
    {
        $parser = new \App\Query\Parsers\CodeSnippetParser;

        $parts = $parser->filterParts(collect([
            '`git push`',
            'ipsum.',
        ]));

        $this->assertEquals(
            $parts->first(),
            '`git push`'
        );
    }
}
