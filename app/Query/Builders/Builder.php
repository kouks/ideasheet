<?php

namespace App\Query\Builders;

use App\Contracts\Query\Analyzer;

abstract class Builder
{
    /**
     * The analyzed instance.
     *
     * @var \App\Contracts\Query\Analyzer
     */
    protected $analyzer;

    /**
     * Class constructor.
     *
     * @param  \App\Contracts\Query\Analyzer  $analyzer
     * @return void
     */
    public function __construct(Analyzer $analyzer)
    {
        $this->analyzer = $analyzer;
    }
}
