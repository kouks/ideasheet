<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Contracts\Query\Analyzer;

class BuilderTest extends TestCase
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
    public function it_correctly_structures_data()
    {
        $analyzer = $this->app->make(Analyzer::class);
        $query = '$ #tag Lorem Ipsum http://idea.dev #000 #tag2';

        $data = $analyzer->analyze($query)->builder()->build();

        $this->assertArraySubset([
            'content' => 'Lorem Ipsum',
            'color' => '#000',
            'query' => '$ #tag Lorem Ipsum http://idea.dev #000 #tag2',
            'tags' => [ 'tag', 'tag2' ],
            'attachments' => [
                [ 'type' => \App\Models\Attachment::LINK, 'content' => 'http://idea.dev' ]
            ]
        ], $data);
    }

    /** @test */
    public function notifying_builder_should_implement_interface()
    {
        $analyzer = $this->app->make(Analyzer::class);
        $query = '$! #tag';

        $builder = $analyzer->analyze($query)->builder();

        $this->assertInstanceOf(
            \App\Contracts\Query\ShouldNotify::class,
            $builder
        );
    }
}
