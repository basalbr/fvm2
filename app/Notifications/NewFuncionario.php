<?php

namespace App\Notifications;

use App\Models\funcionario;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewFuncionario extends Notification
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
        $this->url = route('showFuncionarioToAdmin', [$this->funcionario->id]);
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
            ->line('A empresa '.$this->funcionario->empresa->nome_fantasia.' cadastrou um novo funcionário, o nome dele é ' . $this->funcionario->nome_completo)
            ->line('Para visualizar esse funcionário, clique no botão abaixo:')
            ->action('Visualizar Funcionário', $this->url)
            ->salutation('A equipe WEBContabilidade agradece sua preferência :)')
            ->subject('Novo funcionário')
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
            'mensagem' => 'A empresa '.$this->funcionario->empresa->nome_fantasia.' cadastrou um novo funcionário, o nome dele é ' . $this->funcionario->nome_completo,
            'url' => $this->url
        ];
    }
}
