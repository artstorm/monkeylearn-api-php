<?php

namespace Artstorm\MonkeyLearn\HttpClient;

class Response
{
    /**
     * Contents.
     *
     * @var string
     */
    protected $contents;

    /**
     * Assign dependencies.
     *
     * @param string $contents
     */
    public function __construct($contents)
    {
        $this->contents = $contents;
    }

    /**
     * Get contents.
     *
     * @return string
     */
    public function getContents()
    {
        return $this->contents;
    }
}
