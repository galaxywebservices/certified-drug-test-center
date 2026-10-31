<?php

namespace App\Mail;

use App\Models\CorporateAccount;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CorporatePassDispatchedMail extends Mailable
{
    use Queueable, SerializesModels;

    public CorporateAccount $account;
    public Order $order;
    public Product $product;

    public function __construct(CorporateAccount $account, Order $order, Product $product)
    {
        $this->account = $account;
        $this->order = $order;
        $this->product = $product;
    }

    public function build()
    {
        return $this->subject("Candidate Pass Dispatched - {$this->order->donor_first_name} {$this->order->donor_last_name} [{$this->order->order_number}]")
                    ->view('emails.corporate-pass-dispatched');
    }
}
