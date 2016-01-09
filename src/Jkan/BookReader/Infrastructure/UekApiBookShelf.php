<?php

namespace Jkan\BookReader\Infrastructure;

use Jkan\BookReader\Domain\BookShelf;
use Jkan\BookReader\Domain\Book;
use Jkan\BookReader\Domain\Page;

class UekApiBookShelf implements BookShelf
{
    private $uekApi;
    
    public function getBook($title)
    {
        
    }
}