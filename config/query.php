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
        'codeSnippets' => App\Query\Parsers\CodeSnippetParser::class,
        'color' => App\Query\Parsers\ColorParser::class,
        'images' => App\Query\Parsers\ImageParser::class,
        'links' => App\Query\Parsers\LinkParser::class,
        'tags' => App\Query\Parsers\TagParser::class,
        'content' => App\Query\Parsers\ContentParser::class,
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
    ],

];
