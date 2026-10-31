<?php

namespace App\Mail;

use App\Models\CorporateAccount;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CorporateWelcomeMail extends Mailable
{
    use Queueable, SerializesModels;

    public CorporateAccount $account;
    public string $accountCode;
    public string $accessPin;

    public function __construct(CorporateAccount $account, string $accountCode, string $accessPin)
    {
        $this->account = $account;
        $this->accountCode = $accountCode;
        $this->accessPin = $accessPin;
    }

    public function build()
    {
        return $this->subject("Welcome to Certified Drug Test Centers - Corporate Account #{$this->accountCode}")
                    ->view('emails.corporate-welcome');
    }
}
