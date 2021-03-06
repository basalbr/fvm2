<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ApuracaoCritical extends Notification implements ShouldQueue
{
    use Queueable;
    private $url;
    private $apuracao;
    private $dias;

    public function __construct($apuracao, $dias)
    {
        $this->apuracao = $apuracao;
        $this->dias = $dias;
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
        return ['mail', 'database'];
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
            ->greeting('Olá ' . $notifiable->nome . '!')
            ->line('Verificamos que a apuração do ' . $this->apuracao->imposto->nome . ' da empresa ' . $this->apuracao->empresa->razao_social . ' vencerá em ' . ($this->dias > 1 ? $this->dias . ' dias' : $this->dias . ' dia') . '.')
            ->line('Caso você não nos envie a documentação até ' . ($this->apuracao->vencimento->subDays(4)->isToday() ? 'hoje' : $this->apuracao->vencimento->subDays(4)->format('d/m/Y')) . ', nossos analistas não terão tempo hábil para gerar as guias e será necessário solicitar um recálculo para que façamos a apuração.')
            ->line('Se sua empresa não teve movimento com relação a essa apuração, solicitamos que você informe no sistema que não houve movimento.')
            ->line('Para verificar essa apuração, clique no botão abaixo:')
            ->action('Verificar', $this->url)
            ->salutation('A equipe WEBContabilidade agradece sua preferência :)')
            ->subject('Precisamos que envie os documentos do ' . $this->apuracao->imposto->nome)
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
            'mensagem' => 'Verificamos que a apuração do ' . $this->apuracao->imposto->nome . ' da empresa ' . $this->apuracao->empresa->razao_social . ' vencerá em ' . ($this->dias > 1 ? $this->dias . ' dias' : $this->dias . ' dia') . '.',
            'url' => $this->url
        ];
    }
}
