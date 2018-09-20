<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\MailMessage;
use App\Models\Tugas;
use Illuminate\Support\Facades\DB;
use Auth;

class NotifyAdmin extends Notification
{
    use Queueable;
    public $tugas;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Tugas $tugas)
    {
        $this-> tugas = $tugas;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database','broadcast'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toDatabase($notifiable)
    {


        return
      [
            'data' => $this-> tugas,
            'id_admin' => Auth::id()
      ];

    }


    public function toBroadcast($notifiable)
    {


        return [
          'data' => [
            'data' => $this-> tugas,
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
