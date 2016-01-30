<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class Product
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=100)
     */
    protected $name;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    protected $quantity;

    public function __construct($name)
    {
        $this->name = $name;
        $this->quantity = 0;
    }

    public function name()
    {
        return $this->name;
    }

    public function increaseSupply()
    {
        $this->quantity++;
    }

    public function isAvailable()
    {
        return (boolean) $this->quantity > 0;
    }
}