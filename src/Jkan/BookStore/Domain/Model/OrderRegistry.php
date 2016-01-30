<?php
/**
 * @author Jakub Kanclerz <kuba.kanclerz@creativestyle.pl>
 */

namespace Jkan\BookStore\Domain\Model;

use Jkan\BookCanonicalModel\OrderIdentifier;
use Jkan\BookStore\Domain\Model\Order;

interface OrderRegistry
{

    /**
     * @param OrderIdentifier $id
     * @return Order
     */
    public function getOrderIdentifiedWith(OrderIdentifier $id);
}