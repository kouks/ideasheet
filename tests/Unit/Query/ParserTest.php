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

        $query = $parser->parse('#tag lorem');

        $this->assertEquals($query, 'lorem');
        $this->assertEquals($parser->matches()->toArray(), ['#tag']);
    }

    /** @test */
    public function it_finds_all_tags()
    {
        $parser = new \App\Query\Parsers\TagParser;

        $query = $parser->parse('#tag lorem #tag2');

        $this->assertEquals($query, 'lorem');
        $this->assertEquals($parser->matches()->toArray(), ['#tag', '#tag2']);
    }

    /** @test */
    public function it_finds_a_3_digit_color()
    {
        $parser = new \App\Query\Parsers\ColorParser;

        $query = $parser->parse('#tag lorem #000');

        $this->assertEquals($query, '#tag lorem');
        $this->assertEquals($parser->matches()->toArray(), ['#000']);
    }

    /** @test */
    public function it_finds_a_6_digit_color()
    {
        $parser = new \App\Query\Parsers\ColorParser;

        $query = $parser->parse('#tag lorem #b23432');

        $this->assertEquals($query, '#tag lorem');
        $this->assertEquals($parser->matches()->toArray(), ['#b23432']);
    }

    /** @test */
    public function it_finds_an_image()
    {
        $parser = new \App\Query\Parsers\ImageParser;

        $query = $parser->parse(
            '#tag lorem #b23432 https://example.com/images/test/page https://example.com/images/test.png'
        );

        $this->assertEquals($query, '#tag lorem #b23432 https://example.com/images/test/page');
        $this->assertEquals($parser->matches()->toArray(), ['https://example.com/images/test.png']);
    }

    /** @test */
    public function it_finds_a_link()
    {
        $parser = new \App\Query\Parsers\LinkParser;

        $query = $parser->parse('#tag lorem #b23432 https://example.com/images/test/page');

        $this->assertEquals($query, '#tag lorem #b23432');
        $this->assertEquals($parser->matches()->toArray(), ['https://example.com/images/test/page']);
    }

    /** @test */
    public function it_finds_content()
    {
        $parser = new \App\Query\Parsers\ContentParser;

        $query = $parser->parse('Lorem ipsum dolor');

        $this->assertEquals($query, '');
        $this->assertEquals($parser->matches()->toArray(), ['Lorem ipsum dolor']);
    }

    /** @test */
    public function it_finds_a_code_snippet()
    {
        $parser = new \App\Query\Parsers\CodeSnippetParser;

        $query = $parser->parse('Lorem ipsum dolor `git checkout -- ` `test`');

        $this->assertEquals($query, 'Lorem ipsum dolor');
        $this->assertEquals($parser->matches()->toArray(), ['`git checkout -- `', '`test`']);
    }

    /** @test */
    public function it_finds_a_delimiter()
    {
        $parser = new \App\Query\Parsers\DelimiterParser;

        $query = $parser->parse('$! lorem #tag');

        $this->assertEquals($query, 'lorem #tag');
        $this->assertEquals($parser->matches()->toArray(), ['$!']);

        $query2 = $parser->parse('@ lorem #tag');

        $this->assertEquals($query2, 'lorem #tag');
        $this->assertEquals($parser->matches()->toArray(), ['@']);
    }

    /** @test */
    public function it_parses_uppercase_tag()
    {
        $parser = new \App\Query\Parsers\TagParser;

        $query = $parser->parse('#TAG lorem');

        $this->assertEquals($query, 'lorem');
        $this->assertEquals($parser->matches()->toArray(), ['#TAG']);
    }

    /** @test */
    public function it_tag_that_starts_as_color()
    {
        $parser = new \App\Query\Parsers\ColorParser;

        $query = $parser->parse('#deeplearning lorem');

        $this->assertEquals($query, '#deeplearning lorem');
        $this->assertEquals($parser->matches()->toArray(), []);
    }
}
