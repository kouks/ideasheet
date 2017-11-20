<?php

namespace App\Query\Parsers;

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
}
