<?php

namespace App\Observers;

use App\Models\Payment;

class PaymentObserver
{
    /**
     * Handle the Payment "created" event.
     */
    public function created(Payment $payment): void
    {
        $transaction = $payment->transaction;

        $transaction->payment_status = $transaction->debt == 0 ? 'paid' : 'debt';

        $transaction->save();
    }

    /**
     * Handle the Payment "updated" event.
     */
    public function updated(Payment $payment): void
    {
        $transaction = $payment->transaction;

        $transaction->payment_status = $transaction->debt == 0 ? 'paid' : 'debt';

        $transaction->save();
    }

    /**
     * Handle the Payment "deleted" event.
     */
    public function deleted(Payment $payment): void
    {
        $transaction = $payment->transaction;

        $transaction->payment_status = $transaction->debt == 0 ? 'paid' : 'debt';

        $transaction->save();
    }

    /**
     * Handle the Payment "restored" event.
     */
    public function restored(Payment $payment): void
    {
        //
    }

    /**
     * Handle the Payment "force deleted" event.
     */
    public function forceDeleted(Payment $payment): void
    {
        //
    }
}
