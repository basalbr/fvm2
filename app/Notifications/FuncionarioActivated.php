<?php

namespace App\Notifications;

use App\Models\Funcionario;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class FuncionarioActivated extends Notification implements ShouldQueue
{
    use Queueable;
    private $funcionario;
    private $url;

    /**
     * Create a new notification instance.
     *
     * @param Funcionario $funcionario
     */
    public function __construct(Funcionario $funcionario)
    {
        $this->funcionario = $funcionario;
        $this->url = route('showFuncionarioToUser', [$this->funcionario->empresa->id, $this->funcionario->id]);
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
            ->greeting('Olá ' . $this->funcionario->empresa->usuario->nome. '!')
            ->line('O funcionário '.$this->funcionario->nome_completo.' da empresa '.$this->funcionario->empresa->nome_fantasia.' foi ativado em nosso sistema.')
            ->line('A partir de agora será possível acessar todas as funções referentes ao gerenciamento desse funcionário.')
            ->line('Para visualizar esse funcionário, clique no botão abaixo:')
            ->action('Visualizar Funcionário', $this->url)
            ->salutation('Att,                
                WEBContabilidade :)')
            ->subject('Funcionário ativado')
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
            'mensagem' => 'O funcionário '.$this->funcionario->nome_completo.' da empresa '.$this->funcionario->empresa->nome_fantasia.' foi ativado em nosso sistema.',
            'url' => $this->url
        ];
    }
}
