<?php

namespace App\Notifications;

use App\Models\Chamado;
use App\Models\Tarefa;
use App\Models\Usuario;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TarefaReopened extends Notification implements ShouldQueue
{
    use Queueable;
    private $tarefa;
    private $url;

    /**
     * Create a new notification instance.
     *
     * @param Tarefa $tarefa
     */
    public function __construct(Tarefa $tarefa)
    {
        $this->tarefa = $tarefa;
        $this->url = route('showTarefaToAdmin', [$this->tarefa->id]);
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'mensagem'=> 'A tarefa '.$this->tarefa->assunto.' foi reaberta, favor verificar.',
            'url' => $this->url
        ];
    }
}
