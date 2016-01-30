<?php
/**
 * @author Jakub Kanclerz <kuba.kanclerz@creativestyle.pl>
 */

namespace Jkan\BookStore\Domain\Model;

class Payment
{
    private $compleaded;

    public function confirm()
    {
        $this->compleaded = true;
    }

    public function deny()
    {
        $this->compleaded = false;
    }

    public function isCompleaded()
    {
        return $this->compleaded;
    }
}