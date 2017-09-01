<?php

namespace App\Notifications;

use App\Models\AlteracaoContratual;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class NewAlteracaoContratual extends Notification
{
    use Queueable;
    private $alteracao;
    private $url;

    /**
     * Create a new notification instance.
     *
     * @param AlteracaoContratual $alteracao
     */
    public function __construct(AlteracaoContratual $alteracao)
    {
        $this->alteracao = $alteracao;
        $this->url = route('showAlteracaoContratualToAdmin', [$this->alteracao->id]);
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
            ->line($this->alteracao->funcionario->empresa->usuario->nome.' está solicitando uma alteração contratual para o funcionário '.$this->alteracao->funcionario->nome_completo.' da empresa '.$this->alteracao->funcionario->empresa->nome_fantasia.' ('.$this->alteracao->funcionario->empresa->razao_social.').')
            ->line('Para visualizar essa solicitação, clique no botão abaixo:')
            ->action('Visualizar', $this->url)
            ->salutation('Att,                
                WEBContabilidade :)')
            ->subject('Nova alteração contratual')
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
            'mensagem' => $this->alteracao->funcionario->empresa->usuario->nome.' está solicitando uma alteração contratual para o funcionário '.$this->alteracao->funcionario->nome_completo.' da empresa '.$this->alteracao->funcionario->empresa->nome_fantasia.' ('.$this->alteracao->funcionario->empresa->razao_social.').',
            'url' => $this->url
        ];
    }
}
