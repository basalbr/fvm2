<?php

namespace App\Notifications;

use App\Models\Chamado;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ChamadoFinished extends Notification implements ShouldQueue
{
    use Queueable;
    private $chamado;
    private $url;

    /**
     * Create a new notification instance.
     *
     * @param Chamado $chamado
     */
    public function __construct(Chamado $chamado)
    {
        $this->chamado = $chamado;
        $this->url = route('viewChamado', [$this->chamado->id]);
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail', 'database'];
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
            'mensagem'=> 'Seu chamado referente à ' . $this->chamado->tipoChamado->descricao . ' aberto em ' . $this->chamado->created_at->format('d/m/Y') . ' foi reaberto.',
            'url' => $this->url
        ];
    }
}
