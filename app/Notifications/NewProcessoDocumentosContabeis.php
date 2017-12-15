<?php

namespace App\Notifications;

use App\Models\ProcessoDocumentoContabil;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class NewProcessoDocumentosContabeis extends Notification
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
        $this->url = route('showDocumentoContabilToUser', [$this->processo->id]);
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
            ->greeting('Olá ' . $notifiable->nome.'!')
            ->line('Precisamos que você envie seus documentos contábeis referentes ao período de ' . $this->processo->periodo->format('m/Y'))
            ->line('Para enviar seus documentos, clique no botão abaixo:')
            ->action('Enviar documentos', $this->url)
            ->salutation('A equipe WEBContabilidade agradece sua preferência :)')
            ->subject('Envie seus documentos contábeis')
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
            'mensagem' => 'Precisamos que você envie seus documentos contábeis referentes ao período de ' . $this->processo->periodo->format('m/Y'),
            'url' => $this->url
        ];
    }
}
