<?php

// app/Mail/TransactionSuccess.php
namespace App\Mail;

use App\Models\Transaction;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TransactionSuccess extends Mailable
{
    use Queueable, SerializesModels;

    public $transaction;

    public function __construct(Transaction $transaction)
    {
        $this->transaction = $transaction;
    }

    public function build()
    {
        return $this->subject('Pembayaran Berhasil')
                    ->view('emails.transaction_success');
    }
}