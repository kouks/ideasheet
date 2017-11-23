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
            'content',
            'query',
            'color',
            'tags' => function (Idea $idea) {
                return $idea->tags;
            },
            'attachments' => function (Idea $idea) {
                return $idea->attachments;
            },
            'date' => function (Idea $idea) {
                return $idea->created_at->diffForHumans();
            },
        ];
    }
}
