<?php

namespace Jkan\BookReader\Domain;

interface BookShelf
{
    public function getBook($title);
}
