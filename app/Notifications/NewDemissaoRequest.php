<?php

namespace App\Notifications;

use App\Models\Demissao;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class NewDemissaoRequest extends Notification
{
    use Queueable;
    private $demissao;
    private $url;

    /**
     * Create a new notification instance.
     *
     * @param Demissao $demissao
     */
    public function __construct(Demissao $demissao)
    {
        $this->demissao = $demissao;
        $this->url = route('showDemissaoToAdmin', [$this->demissao->id]);
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        if($notifiable->admin === 1 && $notifiable->id !== 1){
            return ['database'];
        }
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
            ->line($this->demissao->funcionario->empresa->usuario->nome.' está solicitando uma demissão para o funcionário '.$this->demissao->funcionario->nome_completo.' da empresa '.$this->demissao->funcionario->empresa->nome_fantasia.' ('.$this->demissao->funcionario->empresa->razao_social.').')
            ->line('Para visualizar essa solicitação, clique no botão abaixo:')
            ->action('Visualizar Demissão', $this->url)
            ->salutation('Att,                
                WEBContabilidade :)')
            ->subject('Solicitação de demissão')
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
            'mensagem' => $this->demissao->funcionario->empresa->usuario->nome.' está solicitando uma demissão para o funcionário '.$this->demissao->funcionario->nome_completo.' da empresa '.$this->demissao->funcionario->empresa->nome_fantasia.' ('.$this->demissao->funcionario->empresa->razao_social.').',
            'url' => $this->url
        ];
    }
}
