<?php

namespace App\Mail;

use App\Models\Withdrawal;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class WithdrawalStatusChanged extends Mailable
{
    use Queueable, SerializesModels;

    public $withdrawal;
    public $title;
    public $messageLine;

    /**
     * Create a new message instance.
     */
    public function __construct(Withdrawal $withdrawal)
    {
        $this->withdrawal = $withdrawal;

        $amount = number_format($withdrawal->amount_cents / 100, 2);

        if ($withdrawal->status === 'approved') {
            $this->title       = 'Your withdrawal has been approved';
            $this->messageLine = "Your withdrawal request of \${$amount} has been approved. Our team will process your payout shortly.";
        } elseif ($withdrawal->status === 'rejected') {
            $this->title       = 'Your withdrawal has been rejected';
            $this->messageLine = "Your withdrawal request of \${$amount} was rejected. Please contact support if you need more information.";
        } else {
            $this->title       = 'Your withdrawal status has changed';
            $this->messageLine = "Your withdrawal request of \${$amount} has been updated to status: {$withdrawal->status}.";
        }
    }

    /**
     * Build the message.
     */
    public function build()
    {
        // Uses the markdown email template at resources/views/emails/withdrawals/status_changed.blade.php
        return $this->subject($this->title)
            ->markdown('emails.withdrawals.status_changed');
    }
}