<?php

namespace Tests\Unit;

use App\Models\Tag;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class TagTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function it_does_not_store_duplicate_tags()
    {
        $tag = factory(Tag::class)->create();

        $tags = Tag::createNew([$tag->name, 'asdf']);

        $this->assertEquals(
            $tags->first()->id,
            $tag->id
        );

        $this->assertCount(2, Tag::all());
    }
}
