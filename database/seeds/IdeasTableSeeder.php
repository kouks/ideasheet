<?php

use App\Models\Tag;
use App\Models\Idea;
use App\Models\Attachment;
use Illuminate\Database\Seeder;

class IdeasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Idea::class, 50)->create()->each(function (Idea $i) {
            Tag::inRandomOrder()->limit(rand(1, 3))->get()->each(function (Tag $t) use ($i) {
                $i->tags()->attach($t);
            });

            $i->attachments()->saveMany(factory(Attachment::class, rand(0, 2))->make());
        });
    }
}
