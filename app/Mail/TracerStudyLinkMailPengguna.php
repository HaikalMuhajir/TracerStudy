<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Pengguna;

class TracerStudyLinkMailPengguna extends Mailable
{
    use Queueable, SerializesModels;

    public $pengguna;
    public $link;

    public function __construct(Pengguna $pengguna, $link)
    {
        $this->pengguna = $pengguna;
        $this->link = $link;
    }

    public function build()
    {
        return $this->subject('Form Tracer Study')
                    ->markdown('emails.tracer-link-pengguna');
    }
}
