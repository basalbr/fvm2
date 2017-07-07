<?php

namespace App\Notifications;

use App\Models\Apuracao;
use App\Models\ProcessoFolha;
use App\Models\Prolabore;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class ProcessoFolhaSent extends Notification
{
    use Queueable;
    private $processoFolha;
    private $url;

    public function __construct(ProcessoFolha $processoFolha)
    {
        /** @var Apuracao $processoFolha*/
        $this->processoFolha = $processoFolha;
        $this->url = route('showProcessoFolhaToUser', $this->processoFolha->id);
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
            ->greeting('Olá ' . $this->processoFolha->empresa->usuario->nome.'!')
            ->line('Informamos que os recibos de pagamento da empresa '.$this->processoFolha->empresa->nome_fantasia.' ('.$this->processoFolha->competencia->format('m/Y').') já estão disponíveis.')
            ->line('Para acessar, clique no botão abaixo:')
            ->action('Visualizar', $this->url)
            ->salutation('A equipe WEBContabilidade agradece sua preferência :)')
            ->subject('Recibos de pagamento ('.$this->processoFolha->competencia->format('m/Y').')')
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
            'mensagem' => 'Informamos que os recibos de pagamento da empresa '.$this->processoFolha->empresa->nome_fantasia.' ('.$this->processoFolha->competencia->format('m/Y').') já estão disponíveis.',
            'url' => $this->url
        ];
    }
}
