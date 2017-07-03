<?php

namespace App\Notifications;

use App\Models\Empresa;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class EmpresaActivated extends Notification
{
    use Queueable;
    private $empresa;
    private $url;

    /**
     * Create a new notification instance.
     *
     * @param Empresa $empresa
     */
    public function __construct(Empresa $empresa)
    {
        $this->empresa = $empresa;
        $this->url = route('showEmpresaToUser', [$this->empresa->id]);
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
            ->greeting('Olá ' . $this->empresa->usuario. '!')
            ->line('Sua empresa '.$this->empresa->nome_fantasia .' foi ativada em nosso sistema e a partir de agora começam seus 30 dias grátis em nosso sistema.')
            ->line('Para visualizar sua empresa, clique no botão abaixo:')
            ->action('Visualizar Empresa', $this->url)
            ->salutation('A equipe WEBContabilidade agradece sua preferência :)')
            ->subject('Empresa ativada')
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
            'mensagem' => 'Sua empresa '.$this->empresa->nome_fantasia .' foi ativada em nosso sistema e a partir de agora começam seus 30 dias grátis em nosso sistema.',
            'url' => $this->url
        ];
    }
}
