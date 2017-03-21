<?php

namespace App\Notifications;

use App\Models\Mensagem;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class MessageSent extends Notification
{
    use Queueable;

    private $mensagem;
    private $url;

    /**
     * MessageSent constructor.
     * @param Mensagem $mensagem
     */
    public function __construct(Mensagem $mensagem)
    {
        $this->mensagem = $mensagem;
        $this->url = route('showAberturaEmpresaToUser', [$this->mensagem->id_referencia]);
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
     * Define a origem e envia e-mail para o usuário ou para o admin
     *
     * @param  mixed $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        if ($this->mensagem->origem == 'usuario') {
            return $this->toAdminMail($notifiable);
        }
        return $this->toUserMail($notifiable);
    }

    /**
     * Envia o e-mail para o usuário
     *
     * @param  mixed $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    private function toUserMail($notifiable)
    {
        return (new MailMessage)
            ->greeting('Olá ' . $this->mensagem->aberturaEmpresa->usuario->nome)
            ->line('Você recebeu uma nova mensagem de nossa equipe em seu processo de abertura de empresa.')
            ->action('Visualizar Mensagem', $this->url)
            ->line('A equipe WEBContabilidade agradece sua preferência :)')
            ->subject('Você recebeu uma nova mensagem')
            ->from('site@webcontabilidade.com', 'WEBContabilidade');
    }

    /**
     * Envia o e-mail para o usuário
     *
     * @param  mixed $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    private function toAdminMail($notifiable)
    {
        return (new MailMessage)
            ->greeting('Nova mensagem')
            ->line('Você recebeu uma nova mensagem de ' . $this->mensagem->usuario->nome . ' no processo de abertura de empresa.')
            ->line('Para acessar nosso site e visualizar a mensagem, clique no botão abaixo:')
            ->action('Visualizar', $this->url)
            ->subject('Você recebeu uma nova mensagem')
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
            'mensagem' => 'Você recebeu uma nova mensagem em um processo de abertura de empresa.',
            'url' => $this->url
        ];
    }

}
