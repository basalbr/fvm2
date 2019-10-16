<?php

namespace App\Notifications;

use App\Models\Apuracao;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewApuracao extends Notification implements ShouldQueue
{
    use Queueable;
    private $apuracao;
    private $url;

    /**
     * Create a new notification instance.
     *
     * @param Apuracao $apuracao
     */
    public function __construct(Apuracao $apuracao)
    {
        $this->apuracao = $apuracao;
        $this->url = route('showApuracaoToUser', [$this->apuracao->id]);
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
            ->greeting('Olá ' . $this->apuracao->empresa->usuario->nome.'!')
            ->line('Você tem uma nova apuração de ' . $this->apuracao->imposto->nome . ' com vencimento no dia '.$this->apuracao->vencimento->format('d/m/Y'))
            ->line('Você precisa nos enviar seus documentos fiscais até dia 15 caso contrário a apuração será enviada como sem movimento. Depois desse prazo será necessário solicitar recálculo para realizarmos a apuração.')
            ->line('Para visualizar essa apuração, clique no botão abaixo:')
            ->action('Visualizar', $this->url)
            ->salutation('A equipe WEBContabilidade agradece sua preferência :)')
            ->subject('Você tem uma nova apuração ('.$this->apuracao->imposto->nome.')')
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
            'mensagem' => 'Você tem uma nova apuração de ' . $this->apuracao->imposto->nome . 'com vencimento no dia '.$this->apuracao->vencimento->format('d/m/Y'),
            'url' => $this->url
        ];
    }
}
