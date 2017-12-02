<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Anayzer Object
    |--------------------------------------------------------------------------
    |
    | It is responsible for taking the query string and passing it
    | to parsers then, upon requets, returning the correct builder.
    |
    */

    'analyzer' => App\Query\Analyzer::class,

    /*
    |--------------------------------------------------------------------------
    | Parsers Array
    |--------------------------------------------------------------------------
    |
    | Each of these classes contains a regex that corresponds to the
    | query parts.
    |
    */

    'parsers' => [
        'delimiter' => new App\Query\Parsers\DelimiterParser,
        'codeSnippets' => new App\Query\Parsers\CodeSnippetParser,
        'color' => new App\Query\Parsers\ColorParser,
        'images' => new App\Query\Parsers\ImageParser,
        'links' => new App\Query\Parsers\LinkParser,
        'tags' => new App\Query\Parsers\TagParser,
        'content' => new App\Query\Parsers\ContentParser,
    ],

    /*
    |--------------------------------------------------------------------------
    | Builders Array
    |--------------------------------------------------------------------------
    |
    | These are responsible for taking the parsed data and making
    | an object that is acceptable by the controller.
    |
    */

    'builders' => [
        '$' => App\Query\Builders\DefaultBuilder::class,
        '$!' => App\Query\Builders\NotifyingBuilder::class,
        '@' => App\Query\Builders\SearchBuilder::class,
    ],

];
