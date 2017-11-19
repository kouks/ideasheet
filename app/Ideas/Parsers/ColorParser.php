<?php

namespace App\Ideas\Parsers;

class ColorParser extends Parser
{
    /**
     * Provides the regex to filter by.
     *
     * @return string
     */
    public function regex()
    {
        return '/^#([a-f0-9]{3}){1,2}$/';
    }

    /**
     * Provides the name of the parser.
     *
     * @return string
     */
    public function name()
    {
        return 'color';
    }
}
