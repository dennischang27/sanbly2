<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class EmailVerification extends Notification
{
    use Queueable;

    protected $verification_code;
    protected $user;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($verification_code,$user)
    {
        $this->verification_code = $verification_code;
        $this->user = $user;
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
                    ->greeting(__('Hello ').$this->user->name)
                    ->subject(__('Account created in ').env('APP_NAME',""))

                    ->action('Verify', url(env('APP_URL',"")."/verify?code=".$this->verification_code))
                    ->line(__('Thank you for using our service!'));
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
