<?php

namespace App\Query\Parsers;

class TagParser extends Parser
{
    /**
     * Provides the regex to filter by.
     *
     * @return string
     */
    public function regex()
    {
        return '/(#[A-Za-z0-9-]+)/';
    }
}
