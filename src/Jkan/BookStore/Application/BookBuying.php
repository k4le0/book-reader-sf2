<?php
/**
 * @author Jakub Kanclerz <kuba.kanclerz@creativestyle.pl>
 */

namespace Jkan\BookStore\Application;

use Jkan\BookCanonicalModel\BookIdentifier;
use Jkan\BookStore\Domain\Exception\StoreException;
use Jkan\BookStore\Domain\Model\Payment;
use Jkan\BookStore\Domain\Model\OrderRegistry;

class BookBuying
{
    /**
     * @var OrderRegistry
     */
    private $orderRegistry;

    public function completePurchase(OrderIdentifier $id, Payment $payment)
    {
        if ($payment->isCompleaded()) {
            $order = $this->orderRegistry->getOrderIdentifiedWith($id);
            $order->confirm();

            //do sth else

            return;
        }

        throw new StoreException('Missing payment');
    }
}