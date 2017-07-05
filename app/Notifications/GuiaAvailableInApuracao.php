<?php

namespace App\Notifications;

use App\Models\Apuracao;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class GuiaAvailableInApuracao extends Notification
{
    use Queueable;
    private $apuracao;
    private $url;

    /**
     * Apuracao constructor.
     * @param Apuracao $apuracao
     */
    public function __construct(Apuracao $apuracao)
    {
        /** @var Apuracao $apuracao*/
        $this->apuracao = $apuracao;
        $this->url = route('showApuracaoToUser', $this->apuracao->id);
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
            ->greeting('Olá ' . $this->apuracao->empresa->usuario->nome.'!')
            ->line('A sua guia referente ao '.$this->apuracao->imposto->nome. ' já está disponível.')
            ->line('Clique no botão abaixo para acessar a guia e outras informações.')
            ->action('Visualizar', $this->url)
            ->salutation('A equipe WEBContabilidade agradece sua preferência :)')
            ->subject('Guia disponível ('.$this->apuracao->imposto->nome . ')')
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
            'mensagem' => 'A sua guia referente ao '.$this->apuracao->imposto->nome. ' já está disponível.',
            'url' => $this->url
        ];
    }
}
