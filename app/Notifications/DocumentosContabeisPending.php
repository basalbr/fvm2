<?php

namespace App\Notifications;

use App\Models\OrdemPagamento;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class DocumentosContabeisPending extends Notification
{
    use Queueable;
    private $url;
    private $empresa;

    /**
     */
    public function __construct($empresa)
    {
        $this->empresa = $empresa;
        $this->url = route('listDocumentosContabeisToUser');
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail','database'];
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
            ->greeting('Olá ' . $this->empresa->usuario->nome.'!')
            ->line('Verificamos que existem processos de envio de documentos contábeis em aberto no nosso sistema que requerem sua atenção.')
            ->line('Caso você não tenha documentos contábeis para nos enviar, por favor nos informe no sistema que não houve movimentação.')
            ->line('Para verificar essas pendências, clique no botão abaixo:')
            ->action('Verificar Documentos Contábeis', $this->url)
            ->salutation('A equipe WEBContabilidade agradece sua preferência :)')
            ->subject('Documentos contábeis pendentes')
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
            'mensagem' => 'Verificamos que existem processos de envio de documentos contábeis em aberto no nosso sistema que requerem sua atenção.',
            'url' => $this->url
        ];
    }
}
