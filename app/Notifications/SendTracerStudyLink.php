<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class SendTracerStudyLink extends Notification
{
    protected $link;

    public function __construct($link)
    {
        $this->link = $link;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->subject('Link Pengisian Tracer Study POLINEMA')
                    ->line('Silakan klik link berikut untuk mengisi form tracer study:')
                    ->action('Isi Tracer Study', $this->link)
                    ->line('Terima kasih.');
    }
}
