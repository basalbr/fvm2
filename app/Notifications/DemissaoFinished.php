<?php

namespace App\Notifications;

use App\Models\Demissao;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class DemissaoFinished extends Notification
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
        $this->url = route('showDemissaoToUser', [$this->demissao->id]);
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
            ->greeting('Olá ' . $this->demissao->funcionario->empresa->usuario->nome . '!')
            ->line('Sua solicitação de demissão do funcionário '.$this->demissao->funcionario->nome_completo.' da empresa '.$this->demissao->funcionario->empresa->nome_fantasia.' foi conclúida com sucesso!')
            ->line('Para visualizar as informações dessa demissão, clique no botão abaixo:')
            ->action('Visualizar', $this->url)
            ->salutation('Att,                
                WEBContabilidade :)')
            ->subject('Processo de demissão concluído')
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
            'mensagem'=> 'Sua solicitação de demissão do funcionário '.$this->demissao->funcionario->nome_completo.' da empresa '.$this->demissao->funcionario->empresa->nome_fantasia.' foi conclúida com sucesso!',
            'url' => $this->url
        ];
    }
}
