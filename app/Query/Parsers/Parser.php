<?php

namespace App\Query\Parsers;

use App\Contracts\Query\Parser as ParserContract;
use Illuminate\Support\Collection;

abstract class Parser implements ParserContract
{
    /**
     * Filters provided query parts based on child class regex.
     *
     * @param  \Illuminate\Support\Collection  $queryParts
     * @return \Illuminate\Support\Collection
     */
    public function filterParts(Collection $queryParts)
    {
        return $queryParts->filter(function ($part) {
            return (bool) preg_match($this->regex(), $part);
        });
    }

    /**
     * Provides the regex to filter by.
     *
     * @return string
     */
    abstract public function regex();
}
