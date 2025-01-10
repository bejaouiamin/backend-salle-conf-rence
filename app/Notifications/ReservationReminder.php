<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ReservationReminder extends Notification
{
    use Queueable;

    private $reservation;

    public function __construct($reservation)
    {
        $this->reservation = $reservation;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $roomName = $this->reservation->salle->nom; // Access the room name via the salle relationship
        $date = \Carbon\Carbon::parse($this->reservation->start_time)->toDateString();
        $time = \Carbon\Carbon::parse($this->reservation->start_time)->format('H:i');

        return (new MailMessage)
            ->subject('Reservation Reminder')
            ->greeting('Hello!')
            ->line('This is a reminder for your upcoming reservation.')
            ->line('Room: ' . $roomName)
            ->line('Date: ' . $date)
            ->line('Time: ' . $time)
            ->action('View Reservation', url('http://localhost:4200/reservation' . $this->reservation->id))
            ->line('Thank you for using our application!');
    }


    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
