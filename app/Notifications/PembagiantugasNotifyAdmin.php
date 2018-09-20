<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\DB;
use App\Models\Anggota;
use Auth;

class PembagiantugasNotifyAdmin extends Notification
{
    use Queueable;
    public $pembagian;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Anggota $pembagian)
    {
        $this-> pembagian = $pembagian;
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

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toDatabase($notifiable)
    {
      return [
        'data' => $this -> pembagian,
        'id_admin' => Auth::id()
      ];
    }

    public function toBroadcast($notifiable)
    {


        return [
          'data' => [
            'data' => $this -> pembagian,
            'id_admin' => Auth::id()
          ]
        ];

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
