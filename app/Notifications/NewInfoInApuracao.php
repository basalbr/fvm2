<?php

namespace App\Notifications;

use App\Models\Apuracao;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewInfoInApuracao extends Notification implements ShouldQueue
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
        $this->url = route('showApuracaoToAdmin', [$this->apuracao->id]);
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
            ->greeting('Olá !')
            ->line('A apuração ' . $this->apuracao->imposto->nome . ' de '.$this->apuracao->empresa->nome_fantasia . ' possui novas informações.')
            ->line('Para visualizar essa apuração, clique no botão abaixo:')
            ->action('Visualizar Apuração', $this->url)
            ->salutation('A equipe WEBContabilidade agradece sua preferência :)')
            ->subject('Informações enviadas em apuração ('.$this->apuracao->imposto->nome.')')
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
            'mensagem' => 'A apuração ' . $this->apuracao->imposto->nome . ' de '.$this->apuracao->empresa->nome_fantasia . ' possui novas informações.',
            'url' => $this->url
        ];
    }
}
