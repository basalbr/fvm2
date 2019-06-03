<?php

namespace App\Notifications;

use App\Models\ProcessoDocumentoContabil;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class DocumentosContabeisSent extends Notification implements ShouldQueue
{
    use Queueable;
    private $processo;
    private $url;

    /**
     * Create a new notification instance.
     *
     * @param ProcessoDocumentoContabil $processo
     */
    public function __construct(ProcessoDocumentoContabil $processo)
    {
        $this->processo = $processo;
        $this->url = route('showDocumentoContabilToAdmin', [$this->processo->id]);
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail','database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->greeting('Olá!')
            ->line($this->processo->empresa->usuario->nome.' nos enviou os documentos contábeis da empresa '.$this->processo->empresa->nome_fantasia)
            ->line('Para visualizar os documentos, clique no botão abaixo:')
            ->action('Visualizar Documentos Contábeis', $this->url)
            ->salutation('A equipe WEBContabilidade agradece sua preferência :)')
            ->subject('Documentos contábeis enviados')
            ->from('site@webcontabilidade.com', 'WEBContabilidade');
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
            'mensagem' => $this->processo->empresa->usuario->nome.' nos enviou os documentos contábeis da empresa '.$this->processo->empresa->nome_fantasia,
            'url' => $this->url
        ];
    }
}
