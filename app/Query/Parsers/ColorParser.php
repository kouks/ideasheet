<?php

namespace App\Query\Parsers;

class ColorParser extends Parser
{
    /**
     * Provides the regex to filter by.
     *
     * @return string
     */
    public function regex()
    {
        return '/(#([a-f0-9]{3}){1,2})/';
    }
}
