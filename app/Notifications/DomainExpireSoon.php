<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\Hosting;

class DomainExpireSoon extends Notification
{
    use Queueable;

    protected $hosting;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Hosting $hosting)
    {
        $this->hosting = $hosting;
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
        $name = $this->hosting->package == 'Hosting' ? 'hosting' : 'domain';
        $_name = $this->hosting->name;
        return (new MailMessage)
                    ->subject('Your '. $name .' expiring ' .$this->hosting->expire_at->format('M d, Y') )
                    ->greeting('Dear ' . $this->hosting->customer->name )
                    ->line('Your ' . $name . ' "' . $_name . '" is about to expires in less than 30 days.')
                    ->line('To continue to benefit you must renew it on time!')
                    ->line('If it is not renewed before expiration, your websites and other services may stop working.')
                    ->line('For further information, contact us at')
                    ->salutation(
                        config('app.company').'<br>' . 
                        config('app.owner').'<br>' .
                        config('app.phone').'<br>' .
                        config('app.email')
                    )
                    ;
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
