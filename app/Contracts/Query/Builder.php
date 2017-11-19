<?php

namespace App\Contracts\Query;

interface Builder
{
    /**
     * Builds the query from data provided by analyzer.
     *
     * @return array
     */
    public function build();
}
