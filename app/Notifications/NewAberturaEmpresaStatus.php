<?php

namespace App\Notifications;

use App\Models\AberturaEmpresa;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class NewAberturaEmpresaStatus extends Notification
{
    use Queueable;
    private $aberturaEmpresa;
    private $url;

    /**
     * Create a new notification instance.
     *
     * @param AberturaEmpresa $aberturaEmpresa
     */
    public function __construct(AberturaEmpresa $aberturaEmpresa)
    {
        $this->aberturaEmpresa = $aberturaEmpresa;
        $this->url = route('showAberturaEmpresaToUser', [$this->aberturaEmpresa->id]);
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
            ->greeting('Olá '.$notifiable->nome.', tudo bem?')
            ->line('Temos novidades em seu processo de abertura de empresa!')
            ->line($this->aberturaEmpresa->getNomeEtapa().': '.$this->aberturaEmpresa->getDescricaoEtapa().'.')
            ->line('Para acompanhar seu processo é só clicar no botão abaixo.')
            ->action('Visualizar', $this->url)
            ->salutation('A equipe WEBContabilidade agradece sua preferência :)')
            ->subject('Novidades em seu processo de abertura de empresa')
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
            'mensagem' => 'Temos novidades em seu processo de abertura de empresa: '.$this->aberturaEmpresa->getDescricaoEtapa().'.',
            'url' => $this->url
        ];
    }
}
