<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;

class FeaturedOrderPaymentFailedMail extends Mailable
{
    public $order;
    protected $error;

    public function __construct($order, $error)
    {
        $this->order = $order;
        $this->error = $error;
    }

    public function build()
    {
        $url = '/featured-dates-order/'.$this->order->id.'/failed/?payment_id='.$this->error->getError()->payment_intent->id;

        return $this->markdown('emails.featured-order-payment-failed')
            ->with([
                'error' => $this->error,
                'url' => $url,
            ]);
    }
}
