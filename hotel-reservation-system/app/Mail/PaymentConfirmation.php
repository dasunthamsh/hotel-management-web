<?php

namespace App\Mail;

use App\Models\Billing;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PaymentConfirmation extends Mailable
{
    use Queueable, SerializesModels;

    public $billing;

    public function __construct(Billing $billing)
    {
        $this->billing = $billing;
    }

    public function build()
    {
        return $this->view('emails.payment-confirmation')
                    ->subject('Payment Confirmation');
    }
}