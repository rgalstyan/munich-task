<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

final class SendVerificationLinkForeMailChange extends Mailable
{
    use Queueable, SerializesModels;

    public array $mailData;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(array $mailData)
    {
        $this->mailData = $mailData;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject($this->mailData['subject'])
            ->from(config('mail.from')['address'], $this->mailData['subject'])
            ->view('mail/mail-change', $this->mailData);
    }
}
