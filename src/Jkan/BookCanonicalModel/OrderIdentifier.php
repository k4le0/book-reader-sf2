<?php
/**
 * @author Jakub Kanclerz <kuba.kanclerz@creativestyle.pl>
 */

namespace Jkan\BookCanonicalModel;


class OrderIdentifier
{
    private $value;

    /**
     * OrderIdentifier constructor.
     * @param $value
     */
    public function __construct($value)
    {
        $this->value = $value;
    }

    public function isSameAs(OrderIdentifier $id)
    {
        return $this->value === $id->value;
    }
}