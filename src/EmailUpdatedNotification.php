<?php

namespace AlexWinder\ConfirmNewEmail;

use Illuminate\Bus\Queueable;
use Illuminate\Http\Request;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class EmailUpdatedNotification extends Notification
{
    use Queueable;

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
    public function __construct(Request $request)
    {
        $this->old_email = $request->old_email;
        $this->new_email = $request->new_email;
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
                    ->subject('E-Mail Address Updated')
                    ->markdown('confirm-new-email::mail.email-updated', [
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
