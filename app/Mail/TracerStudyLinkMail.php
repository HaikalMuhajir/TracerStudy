<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Alumni;

class TracerStudyLinkMail extends Mailable
{
    use Queueable, SerializesModels;

    public $alumni;
    public $link;

    public function __construct(Alumni $alumni, $link)
    {
        $this->alumni = $alumni;
        $this->link = $link;
    }

    public function build()
    {
        return $this->subject('Form Tracer Study')
            ->markdown('emails.tracer-link');
    }
}
