<?php
/**
 * @author Jakub Kanclerz <kuba.kanclerz@creativestyle.pl>
 */

namespace Jkan\BookStore\Domain\Model;

interface BookStore
{
    public function isAvailable(BookIdentifier $id);
}