<?php

namespace App\Notifications;

use App\Models\Chamado;
use App\Models\Tarefa;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TarefaCreated extends Notification implements ShouldQueue
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
     * Get the mail representation of the notification.
     *
     * @param  mixed $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->greeting('Olá ' . $this->chamado->usuario->nome . '!')
            ->line('Seu chamado referente à ' . $this->chamado->tipoChamado->descricao . ' aberto em ' . $this->chamado->created_at->format('d/m/Y') . ' foi concluído.')
            ->line('Para visualizar esse chamado, clique no botão abaixo:')
            ->action('Visualizar Chamado', $this->url)
            ->salutation('A equipe WEBContabilidade agradece sua preferência :)')
            ->subject('Chamado concluído')
            ->from('site@webcontabilidade.com', 'WEBContabilidade');
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
            'mensagem'=> 'Você possui uma nova tarefa (' . $this->tarefa->assunto . ') para resolver até ' . $this->tarefa->expectativa_conclusao_em->format('d/m/Y à\s H:i'),
            'url' => $this->url
        ];
    }
}
