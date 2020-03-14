<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class ClienteCriado extends Notification
{
    use Queueable;

    public $cliente;

    public function __construct($cliente)
    {
        $this->cliente = $cliente;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database', 'broadcast'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'cliente' => $this->cliente,
        ];
    }

    public function toBroadcast($notifiable)
    {
        return [
            'cliente' => $this->cliente,
        ];
    }
}
