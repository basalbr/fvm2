<?php

namespace App\Notifications;

use App\Models\ProcessoDocumentoContabil;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class ProcessoDocumentoContabilFinished extends Notification
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
            ->greeting('Olá '.$this->processo->empresa->usuario->nome.'!')
            ->line('Informamos que o processo de envio de documentos contábeis do período de '.$this->processo->periodo->format('m/Y').' foi concluído.')
            ->line('Para visualizar o processo, clique no botão abaixo:')
            ->action('Visualizar', $this->url)
            ->salutation('A equipe WEBContabilidade agradece sua preferência :)')
            ->subject('Processo de documentos contábeis concluído')
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
            'mensagem' => 'O processo de envio de documentos contábeis do período de '.$this->processo->periodo->format('m/Y').' foi concluído.',
            'url' => $this->url
        ];
    }
}
