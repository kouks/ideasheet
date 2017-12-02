<?php

namespace App\Query\Parsers;

use App\Contracts\Query\Parser as ParserContract;

abstract class Parser implements ParserContract
{
    /**
     * The collection of all matches from the query.
     *
     * @var \Illuminate\Support\Collection
     */
    protected $matches;

    /**
     * Filters provided query based on regex.
     *
     * @param  string  $query
     * @return string
     */
    public function parse(string $query)
    {
        preg_match_all($this->regex(), $query, $matches);

        $this->setMatches($matches[1]);

        return trim(preg_replace($this->regex(), '', $query));
    }

    /**
     * Returns all matches from the previously parsed query string.
     *
     * @return \Illuminate\Support\Collection
     */
    public function matches()
    {
        return $this->matches;
    }

    /**
     * Saves the matches to an instance variable.
     *
     * @param  array  $matches
     * @return void
     */
    protected function setMatches(array $matches)
    {
        $this->matches = collect($matches);
    }

    /**
     * Provides the regex to filter by.
     *
     * @return string
     */
    abstract public function regex();
}
