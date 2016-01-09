<?php

namespace Jkan\BookReader\Infrastructure;

use Jkan\BookReader\Domain\BookShelf;
use Jkan\BookReader\Domain\Book;
use Jkan\BookReader\Domain\Page;

class InMemoryBookShelf implements BookShelf
{
    public function getBook($title)
    {
        $book = new Book(
            $title,
            [
                new Page('content of page 1'),
                new Page('content of page 2'),
                new Page('content of page 3'),
                new Page('content of page 4'),
            ]
        );

        return $book;
    }
}