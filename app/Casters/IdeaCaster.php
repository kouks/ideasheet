<?php

namespace App\Casters;

use App\Models\Idea;
use Koch\Casters\Caster;

class IdeaCaster extends Caster
{
    /**
     * The rules to cast the model by.
     *
     * @return array
     */
    public function castRules()
    {
        return [
            'id',
            'content',
            'query',
            'color',
            'tags' => function (Idea $idea) {
                return $idea->tags->toArray();
            },
            'attachments' => function (Idea $idea) {
                return $idea->attachments->toArray();
            },
            'author' => function (Idea $idea) {
                return $idea->user->name;
            },
            'date' => function (Idea $idea) {
                return $idea->created_at->diffForHumans();
            },
        ];
    }
}
