<?php

namespace App\Query\Builders;

use App\Contracts\Query\Builder as BuilderContract;

abstract class Builder implements BuilderContract
{
    /**
     * The parsers containing the parsed query.
     *
     * @var array
     */
    protected $parsers;

    /**
     * The original query.
     *
     * @var string
     */
    protected $query;

    /**
     * The list of attachment data types.
     *
     * @var array
     */
    protected $attachments = ['links', 'images', 'codeSnippets'];

    /**
     * Class constructor.
     *
     * @param  array  $parsers
     * @param  string  $query
     * @return void
     */
    public function __construct(array $parsers, string $query)
    {
        $this->parsers = $parsers;
        $this->query = $query;
    }

    /**
     * Builds the query from data provided by analyzer.
     *
     * @return array
     */
    public function build()
    {
        return [
            'content' => $this->buildContent(),
            'color' => $this->buildColor(),
            'query' => $this->query,
            'tags' => $this->buildTags(),
            'attachments' => $this->buildAttachments(),
        ];
    }

    /**
     * Builds the content part of the data.
     *
     * @return string
     */
    protected function buildContent()
    {
        return $this->parsers['content']->matches()->first();
    }

    /**
     * Builds the color part of the data.
     *
     * @return string
     */
    protected function buildColor()
    {
        return $this->parsers['color']->matches()->first();
    }

    /**
     * Builds the tags part of the data.
     *
     * @return array
     */
    protected function buildTags()
    {
        return $this->parsers['tags']->matches()->map(function ($tag) {
            return substr($tag, 1, strlen($tag));
        })->values()->toArray();
    }

    /**
     * Builds the attachments part of the data.
     *
     * @return array
     */
    protected function buildAttachments()
    {
        $attachments = collect([]);

        foreach ($this->attachments as $type => $typeName) {
            $matches = $this->parsers[$typeName]->matches();

            $attachments = $attachments->concat($matches->map(function ($content) use ($type) {
                return compact('type', 'content');
            }));
        }

        return $attachments->values()->toArray();
    }
}
