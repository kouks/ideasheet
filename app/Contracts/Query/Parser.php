<?php

namespace App\Contracts\Query;

use Illuminate\Support\Collection;

interface Parser
{
    /**
     * Filters provided query parts based on regex.
     *
     * @param  \Illuminate\Support\Collection  $queryParts
     * @return \Illuminate\Support\Collection
     */
    public function filterParts(Collection $queryParts);

    /**
     * Provides the regex to filter by.
     *
     * @return string
     */
    public function regex();
}
