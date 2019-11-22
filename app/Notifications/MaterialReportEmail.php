<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\Models\NotificationEmail;
use Illuminate\Support\Facades\Storage;

class MaterialReportEmail extends Notification implements ShouldQueue
{
    use Queueable;

    protected $filename;
    protected $email;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($filename,$email)
    {
        $this->filename = $filename;
        $this->email = $email;
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
        $cc = explode(",",$this->email->cc);
        return (new MailMessage)
                    ->cc($cc)
                    ->subject($this->filename)
                    ->greeting('Greetings,')
                    ->line('Please find the attached materials report.')
                    ->line('This is a system generated mail. Please do not reply.')
                    ->line('Thank you very much.')
                    ->attach(Storage::disk('material_report')->path($this->filename.'.xlsx'));
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
