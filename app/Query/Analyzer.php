<?php

namespace App\Query;

use App\Http\Requests\IdeaRequest;
use App\Exceptions\Query\QueryNotAnalyzedException;
use App\Contracts\Query\Analyzer as AnalyzerContract;
use App\Exceptions\Query\InvalidBuilderDelimiterException;

class Analyzer implements AnalyzerContract
{
    /**
     * The query part delimiter that the query is split by.
     *
     * @var string
     */
    protected $queryPartDelimiter = ' ';

    /**
     * The delimiter that decides what builders is going to be used.
     *
     * @var string
     */
    protected $builderDelimiter;

    /**
     * The provided query.
     *
     * @var string
     */
    protected $query;

    /**
     * The parsed query.
     *
     * @var array
     */
    protected $parsed = [];

    /**
     * The array of parsers.
     *
     * @var array
     */
    protected $parsers;

    /**
     * The array of builders.
     *
     * @var array
     */
    protected $builders;

    /**
     * Class constructor.
     *
     * @param  array  $parsers
     * @param  array  $builders
     * @return void
     */
    public function __construct(array $parsers, array $builders)
    {
        $this->parsers = $parsers;
        $this->builders = $builders;
    }

    /**
     * Analyze the given query string based on provided parsers.
     *
     * @param  string  $query
     * @return self
     *
     * @throws \App\Exceptions\Query\InvalidBuilderDelimiterException
     */
    public function analyze(string $query)
    {
        $this->query = $query;

        $parts = $this->splitQuery();

        $this->assignBuilderDelimiter($parts->shift());

        foreach ($this->parsers as $name => $parser) {
            $parser = new $parser;

            $filtered = $parser->filterParts($parts);

            $this->parsed[$name] = $filtered;

            $parts = $parts->diff($filtered);
        }

        return $this;
    }

    /**
     * Retrieve correct builder to further work with the parsed data
     *
     * @return \App\Query\Builders\Builder
     *
     * @throws \App\Exceptions\Query\QueryNotAnalyzedException
     */
    public function builder()
    {
        if (! $this->builderDelimiter) {
            throw new QueryNotAnalyzedException('The query needs to be analyzed first.');
        }

        $builder = $this->builders[$this->builderDelimiter];

        return new $builder($this);
    }

    /**
     * Assigns the buidler delimiter to an instance variable.
     *
     * @param  string  $delimiter
     * @return void
     *
     * @throws \App\Exceptions\Query\InvalidBuilderDelimiterException
     */
    protected function assignBuilderDelimiter(string $delimiter)
    {
        if (!array_key_exists($delimiter, $this->builders)) {
            throw new InvalidBuilderDelimiterException("The delimiter [$delimiter] is invalid.");
        }

        $this->builderDelimiter = $delimiter;
    }

    /**
     * Function to split the query based on the delimiter.
     *
     * @return \Illuminate\Support\Collection
     */
    protected function splitQuery()
    {
        return collect(explode($this->queryPartDelimiter, $this->query));
    }

    /**
     * Returns the parsed query array.
     *
     * @return array
     */
    public function parsedQuery()
    {
        return $this->parsed;
    }
}
