<?php

namespace App\Ideas\Parsers;

class ImageParser extends Parser
{
    /**
     * List of extensions an image can have.
     */
    const TYPES = [];

    /**
     * Provides the regex to filter by.
     *
     * @return string
     */
    public function regex()
    {
        return '/https?:\/\/(www\.)?[-a-zA-Z0-9@:%._\+~#=]{2,256}\.[a-z]{2,6}\b([-a-zA-Z0-9@:%_\+.~#?&\/\/=]*).(png|jpg|jpeg|gif|bmp|svg)/';
    }

    /**
     * Provides the name of the parser.
     *
     * @return string
     */
    public function name()
    {
        return 'images';
    }
}
