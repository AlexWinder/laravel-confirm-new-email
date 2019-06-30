<?php

namespace AlexWinder\ConfirmNewEmail;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class ConfirmNewEmailNotification extends Notification
{
    use Queueable;

    /**
     * The URL to confirm the new email address.
     *
     * @var string
     */
    public $url;

    /**
     * The new email address.
     *
     * @var string
     */
    public $new_email;

    /**
     * The old email address.
     *
     * @var string
     */
    public $old_email;

    /**
     * Create a new notification instance.
     *
     * @param string $url
     * @param array $parameters
     */
    public function __construct($url, $parameters)
    {
        $this->url = $url;
        $this->old_email = $parameters['old_email'];
        $this->new_email = $parameters['new_email'];
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->subject('Confirm New E-Mail')
                    ->markdown('confirm-new-email::mail.confirm-new-email', [
                        'url' => $this->url,
                        'old_email' => $this->old_email,
                        'new_email' => $this->new_email,
                    ]);
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
