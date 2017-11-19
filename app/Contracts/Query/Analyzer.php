<?php

namespace App\Contracts\Query;

interface Analyzer
{
    /**
     * Analyze the given query string based on provided parsers.
     *
     * @param  string  $query
     * @return self
     *
     * @throws \App\Exceptions\Query\InvalidBuilderDelimiterException
     */
    public function analyze(string $query);

    /**
     * Retrieve correct builder to further work with the parsed data
     *
     * @return \App\Query\Builders\Builder
     *
     * @throws \App\Exceptions\Query\QueryNotAnalyzedException
     */
    public function builder();
}
