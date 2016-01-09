<?php

namespace Jkan\BookReader\Domain;

class Page
{
    private $content;

    public function __construct($content)
    {
        $this->content = $content;
    }

    public function content()
    {
        return $this->content;
    }
}