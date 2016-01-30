<?php
/**
 * @author Jakub Kanclerz <kuba.kanclerz@creativestyle.pl>
 */

namespace Jkan\BookStore\Domain\Model;

class Book
{
    private $identificator;
    private $price;

    /**
     * Book constructor.
     * @param $identificator
     * @param $price
     */
    public function __construct($identificator, $price)
    {
        $this->identificator = $identificator;
        $this->price = $price;
    }

    public function price()
    {
        return $this->price;
    }
}