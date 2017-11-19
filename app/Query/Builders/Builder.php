<?php

namespace App\Query\Builders;

use Closure;
use Illuminate\Support\Collection;
use App\Contracts\Query\Builder as BuilderContract;

abstract class Builder implements BuilderContract
{
    /**
     * The previously parsed query.
     *
     * @var \Illuminate\Support\Collection
     */
    protected $data;

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
     * @param  array  $data
     * @param  string  $query
     * @return void
     */
    public function __construct(Collection $data, string $query)
    {
        $this->data = $data;
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
        return $this->data->get('content')->implode(' ');
    }

    /**
     * Builds the color part of the data.
     *
     * @return string
     */
    protected function buildColor()
    {
        return $this->data->get('color')->first();
    }

    /**
     * Builds the tags part of the data.
     *
     * @return array
     */
    protected function buildTags()
    {
        return $this->data->get('tags')->map(function ($tag) {
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
            $attachments = $attachments->concat($this->data->get($typeName)->map(function ($content) use ($type) {
                return compact('type', 'content');
            }));
        }

        return $attachments->values()->toArray();
    }
}
