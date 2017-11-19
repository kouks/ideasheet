<?php

namespace App\Ideas\Parsers;

class ContentParser extends Parser
{
    /**
     * Provides the regex to filter by.
     *
     * @return string
     */
    public function regex()
    {
        return '/.+/';
    }

    /**
     * Provides the name of the parser.
     *
     * @return string
     */
    public function name()
    {
        return 'content';
    }
}
