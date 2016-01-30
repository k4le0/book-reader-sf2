<?php
/**
 * @author Jakub Kanclerz <kuba.kanclerz@creativestyle.pl>
 */

namespace Jkan\BookStore\Infrastructure\Payment;

use Jkan\BookStore\Domain\Model\Payment;

class DotpayPaymentFactory
{
    public function createPayment(DotpayCompletePayment $completePayment)
    {
        $payment = new Payment();

        if ($completePayment->isSuccessful()) {
            $payment->confirm();
            return $payment;
        }

        $payment->deny();

        return $payment;
    }
}