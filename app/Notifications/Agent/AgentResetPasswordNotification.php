<?php

namespace App\Notifications\Agent;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class AgentResetPasswordNotification extends Notification
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
                    ->subject('Reset Password Notification')
                    ->line('You are receiving this email because we received a password reset request for your account.')
                    ->action('Reset Password', url('agent/reset-password', [
                        'token' => $this->token,
                    ]))
                    ->line('If you did not request a password reset, no further action is required.');
    }
}