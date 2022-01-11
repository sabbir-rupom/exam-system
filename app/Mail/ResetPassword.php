<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ResetPassword extends Mailable
{
    use Queueable, SerializesModels;

    private $data;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(array $data = [])
    {
        $this->data = $data;
        if (isset($this->data['subject']) && !empty($this->data['subject'])) {
            $this->subject($this->data['subject']);
        } else {
            $this->subject('Request to Change Somriddhi Account Password');
        }
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('template.email.reset-password', $this->data);
    }
}
