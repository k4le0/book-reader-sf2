<?php

namespace Jkan\BookReader\Application;

use Jkan\BookReader\Domain\BookShelf;

class BookService
{
    private $bookShelf;

    public function __construct(BookShelf $bookShelf)
    {
        $this->bookShelf = $bookShelf;
    }

    public function readBook($title, $page)
    {
        $book = $this->bookShelf->getBook($title);

        return $book->read($page);
    }
}
