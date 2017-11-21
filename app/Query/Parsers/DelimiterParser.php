<?php

namespace App\Query\Parsers;

class DelimiterParser extends Parser
{
    /**
     * Array of available delimiters.
     *
     * @return array
     */
    private static $DELIMITERS = ['$!', '$', '@'];

    /**
     * Provides the regex to filter by.
     *
     * @return string
     */
    public function regex()
    {
        return '/^'.$this->delimitersToRegex().'/';
    }

    /**
     * Returns a regex built from all available delimiters.
     *
     * @return string
     */
    protected function delimitersToRegex()
    {
        $delimiters = array_map(function ($delimiter) {
            return preg_quote($delimiter);
        }, static::$DELIMITERS);

        return '(' . implode('|', $delimiters) . ')';
    }
}
