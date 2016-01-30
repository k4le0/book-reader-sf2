<?php
/**
 * @author Jakub Kanclerz <kuba.kanclerz@creativestyle.pl>
 */

namespace Jkan\BookCanonicalModel;


class BookIdentifier
{
    private $value;

    /**
     * BookIdentificator constructor.
     * @param $value
     */
    public function __construct($value)
    {
        $this->value = $value;
    }

    public function isSameAs(BookIdentifier $id)
    {
        return $this->value === $id->value;
    }
}