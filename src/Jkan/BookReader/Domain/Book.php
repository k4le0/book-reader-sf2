<?php

namespace Jkan\BookReader\Domain;

class Book
{
    private $pages;
    private $title;

    public function __construct(
        $title,
        array $pages
    ) {
        $this->pages = $pages;
        $this->title = $title;
    }

    public function read($pageNumber)
    {
        $page = $this->pages[$pageNumber-1];

        return $page->content();
    }
}