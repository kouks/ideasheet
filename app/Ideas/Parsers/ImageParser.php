<?php

namespace App\Ideas\Parsers;

class ImageParser extends Parser
{
    /**
     * Provides the regex to filter by.
     *
     * @return string
     */
    public function regex()
    {
        return '/asdasd/';
    }

    /**
     * Provides the name of the parser.
     *
     * @return string
     */
    public function name()
    {
        return 'images';
    }
}
