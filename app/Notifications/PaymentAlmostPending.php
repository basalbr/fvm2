<?php

namespace App\Notifications;

use App\Models\OrdemPagamento;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class PaymentAlmostPending extends Notification
{
    use Queueable;
    private $ordemPagamento;
    private $url;

    /**
     * OrdemPagamentoPaid constructor.
     * @param OrdemPagamento $ordemPagamento
     */
    public function __construct(OrdemPagamento $ordemPagamento)
    {
        $this->ordemPagamento = $ordemPagamento;
        $this->url = route('listOrdensPagamentoToUser');
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
            ->greeting('Olá ' . $this->ordemPagamento->usuario->nome.'!')
            ->line('Sua ordem de pagamento no valor de R$'.$this->ordemPagamento->formattedValue().' vai vencer em '.$this->ordemPagamento->vencimento->format('d/m/Y').'!')
            ->line('Caso você já tenha efetuado o pagamento, por favor entre em contato conosco.')
            ->action('Verificar Pagamentos', $this->url)
            ->salutation('A equipe WEBContabilidade agradece sua preferência :)')
            ->subject('Sua ordem de pagamento vencerá em breve')
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
            'mensagem' => 'Sua ordem de pagamento no valor de R$'.$this->ordemPagamento->formattedValue().' vai vencer em '.$this->ordemPagamento->vencimento->format('d/m/Y').'!',
            'url' => $this->url
        ];
    }
}
