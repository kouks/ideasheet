<?php

namespace App\Query\Parsers;

class CodeSnippetParser extends Parser
{
    /**
     * Provides the regex to filter by.
     *
     * @return string
     */
    public function regex()
    {
        return '/`.+`/';
    }
}
