<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class ResetPassword extends Notification
{
    public $token;

    public function __construct($token)
    {
        $this->token = $token;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Verification of email address to change password')
            ->greeting('Hello,')
            ->line('You receive this message because we have received a password renewal request for your account.')
            ->line('Please use the button below to verify your email address before changing your password')
            ->action('Renew my password', url('password/reset', $this->token))
            ->line('If you have not made this request, no further action is required.')
            ->salutation('Best regards,');
    }
}
