<?php

namespace App\Notifications;

use App\Models\Apuracao;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewStatusApuracao extends Notification implements ShouldQueue
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
            ->line('O status da apuração referente ao '.$this->apuracao->imposto->nome. ' foi alterado para: '.$this->apuracao->status)
            ->line('Clique no botão abaixo para acessar visualizar a apuração.')
            ->action('Visualizar', $this->url)
            ->salutation('A equipe WEBContabilidade agradece sua preferência :)')
            ->subject('Novo status em apuração ('.$this->apuracao->imposto->nome . ')')
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
            'mensagem' => 'O status da apuração referente ao '.$this->apuracao->imposto->nome. ' foi alterado para:'.$this->apuracao->status,
            'url' => $this->url
        ];
    }
}
