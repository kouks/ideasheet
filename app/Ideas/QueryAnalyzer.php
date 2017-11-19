<?php

namespace App\Ideas;

use App\Http\Requests\IdeaRequest;

class QueryAnalyzer
{
    /**
     * The split delimiter.
     *
     * @var string
     */
    protected $splitDelimiter = ' ';

    /**
     * The validation delimiter.
     *
     * @var string
     */
    protected $validationDelimiter = '$';

    /**
     * The parsed query.
     *
     * @var string
     */
    protected $parsed = [];

    /**
     * Array of query parsers.
     *
     * @var array
     */
    protected $parsers = [
        Parsers\CodeSnippetParser::class,
        Parsers\ColorParser::class,
        Parsers\ImageParser::class,
        Parsers\LinkParser::class,
        Parsers\TagParser::class,
    ];

    /**
     * Function to split parse the query by running it through
     * predefinied parsers
     *
     * @param  string  $query
     * @return void
     */
    public function parseQuery(string $query)
    {
        $parts = $this->splitQuery($query);

        $parts->shift();

        foreach ($this->parsers as $parser) {
            $parser = new $parser;

            $filtered = $parser->filterParts($parts);

            $this->parsed[$parser->name()] = $filtered;

            $parts = $parts->diff($filtered);
        }

        $this->parsed['content'] = $parts;
    }

    /**
     * Function to split the query based on the delimiter.
     *
     * @param  string  $query
     * @return \Illuminate\Support\Collection
     */
    protected function splitQuery(string $query)
    {
        return collect(explode($this->splitDelimiter, $query));
    }

    /**
     * Global getter. If the attribute name exists in the parsed
     * array, retrun it.
     *
     * @param  string  $attribute
     * @return \Illuminate\Support\Collection|null
     */
    public function __get($attribute)
    {
        return array_key_exists($attribute, $this->parsed)
            ? $this->parsed[$attribute]
            : null;
    }
}
