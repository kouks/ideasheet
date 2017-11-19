<?php

namespace App\Ideas\Parsers;

class LinkParser extends Parser
{
    /**
     * Provides the regex to filter by.
     *
     * @return string
     */
    public function regex()
    {
        return '/asdasdasd/';
    }

    /**
     * Provides the name of the parser.
     *
     * @return string
     */
    public function name()
    {
        return 'links';
    }
}
