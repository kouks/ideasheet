<?php

namespace App\Query;

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
     */
    public function analyze(string $query)
    {
        $this->query = $query;

        foreach ($this->parsers as $parser) {
             $query = $parser->parse($query);
        }

        return $this;
    }

    /**
     * Retrieve correct builder to further work with the parsed data.
     *
     * @return \App\Query\Builders\Builder
     *
     * @throws \App\Exceptions\Query\InvalidBuilderDelimiterException
     * @throws \App\Exceptions\Query\QueryNotAnalyzedException
     */
    public function builder()
    {
        $builder = $this->builders[$this->getBuilderDelimtier()];

        return new $builder($this->parsers, $this->query);
    }

    /**
     * Determines the builder delimiter from the DelmiterParser class instance.
     *
     * @return string
     *
     * @throws \App\Exceptions\Query\InvalidBuilderDelimiterException
     * @throws \App\Exceptions\Query\QueryNotAnalyzedException
     */
    protected function getBuilderDelimtier()
    {
        $delimtierParser = $this->parsers['delimiter'];

        if (! $delimtierParser->matches()) {
            throw new QueryNotAnalyzedException('The query needs to be analyzed first.');
        }

        $delimiter = $delimtierParser->matches()->first();

        if (! array_key_exists($delimiter, $this->builders)) {
            throw new InvalidBuilderDelimiterException("The delimiter [$delimiter] is invalid.");
        }

        return $delimiter;
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
