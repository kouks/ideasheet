<?php

namespace App\Ideas\Parsers;

class TagParser extends Parser
{
    /**
     * Provides the regex to filter by.
     *
     * @return string
     */
    public function regex()
    {
        return '/^#[a-z0-9-]+$/';
    }

    /**
     * Provides the name of the parser.
     *
     * @return string
     */
    public function name()
    {
        return 'tags';
    }
}
