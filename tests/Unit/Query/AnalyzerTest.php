<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Contracts\Query\Analyzer;

class AnalyzerTest extends TestCase
{
    /**
     * Boots the application and sets up unit tests.
     */
    public function setUp()
    {
        parent::setUp();

        $this->app = $this->createApplication();
    }

    /**
     * @test
     * @expectedException \App\Exceptions\Query\InvalidBuilderDelimiterException
     */
    public function it_correctly_throws_an_exception_when_invalid_delimiter()
    {
        $analyzer = $this->app->make(Analyzer::class);

        $analyzer->analyze('Lorem #test ipsum.')->builder();
    }

    /**
     * @test
     * @expectedException \App\Exceptions\Query\QueryNotAnalyzedException
     */
    public function it_throws_an_exception_when_query_not_analyzed()
    {
        $analyzer = $this->app->make(Analyzer::class);

        $analyzer->builder();
    }

    /** @test */
    public function it_returns_a_correct_builder()
    {
        $analyzer1 = $this->app->make(Analyzer::class);
        $analyzer2 = $this->app->make(Analyzer::class);

        $builder1 = $analyzer1->analyze('$ test')->builder();
        $builder2 = $analyzer2->analyze('$! test')->builder();

        $this->assertEquals(
            get_class($builder1),
            config('query.builders.$')
        );

        $this->assertEquals(
            get_class($builder2),
            config('query.builders.$!')
        );
    }
}
