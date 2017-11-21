<?php

namespace App\Contracts\Query;

interface Parser
{
    /**
     * Filters provided query based on regex.
     *
     * @param  string  $query
     * @return string
     */
    public function parse(string $query);

    /**
     * Returns all matches from the previously parsed query string.
     *
     * @return \Illuminate\Support\Collection
     */
    public function matches();

    /**
     * Provides the regex to filter by.
     *
     * @return string
     */
    public function regex();
}
