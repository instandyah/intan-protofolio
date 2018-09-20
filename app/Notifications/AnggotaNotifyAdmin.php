<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\Models\Anggota;
use Illuminate\Support\Facades\DB;
use Auth;

class AnggotaNotifyAdmin extends Notification
{
    use Queueable;
    public $anggota;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct( Anggota $anggota)
    {
        $this-> anggota = $anggota;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
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
          'data' => $this -> anggota,
          'id_admin' => Auth::id()
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
