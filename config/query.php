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

    'analyzer' => App\Ideas\QueryAnalyzer::class,

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
        'codeSnippet' => App\Ideas\Parsers\CodeSnippetParser::class,
        'color' => App\Ideas\Parsers\ColorParser::class,
        'images' => App\Ideas\Parsers\ImageParser::class,
        'links' => App\Ideas\Parsers\LinkParser::class,
        'tags' => App\Ideas\Parsers\TagParser::class,
        'content' => App\Ideas\Parsers\ContentParser::class,
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
        '$' => App\Ideas\Builders\DefaultBuilder::class,
        '$!' => App\Ideas\Builders\NotifyingBuilder::class,
    ]

];
