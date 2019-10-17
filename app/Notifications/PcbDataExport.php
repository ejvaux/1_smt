<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class PcbDataExport extends Notification implements ShouldQueue
{
    use Queueable;

    protected $msg;
    protected $name;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($msg,$name)
    {
        $this->msg = $msg;
        $this->name = $name;
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
        /* return (new MailMessage)
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!'); */

        return (new MailMessage)
                    ->error()
                    ->subject('*** WARNING - SMT MES EXPORT ***')                    
                    ->greeting('Hi '.$this->name.'!')
                    ->line($this->msg)
                    ->line('Please check the Integration System immediately!!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    /* public function toArray($notifiable)
    {
        return [
            //
        ];
    } */
}
