<?php

namespace App\Mail;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OnlineOrderNotificationMail extends Mailable
{
    use Queueable, SerializesModels;

    public Order $order;

    /**
     * Create a new message instance.
     */
    public function __construct(Order $order)
    {
        $this->order = $order->loadMissing(['items.product', 'location']);
    }

    /**
     * Build the message.
     */
    public function build()
    {
        $primaryItem = $this->order->items->first();
        $productName = $primaryItem ? $primaryItem->product_name : 'Drug Test Registration';

        return $this->subject("New Online Order #{$this->order->order_number} - {$this->order->donor_full_name} ({$productName})")
                    ->view('emails.online-order');
    }
}

