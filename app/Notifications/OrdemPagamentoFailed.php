<?php

namespace App\Notifications;

use App\Models\OrdemPagamento;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class OrdemPagamentoFailed extends Notification
{
    use Queueable;
    private $ordemPagamento;
    private $url;
    private $chamadoUrl;

    /**
     * OrdemPagamentoFailed constructor.
     * @param OrdemPagamento $ordemPagamento
     */
    public function __construct(OrdemPagamento $ordemPagamento)
    {
        $this->ordemPagamento = $ordemPagamento;
        $this->url = route('showOrdemPagamentoToUser', [$this->ordemPagamento->id]);
        $this->chamadoUrl = route('createChamado',['pagamento']);
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
            ->greeting('Olá ' . $this->ordemPagamento->usuario->nome)
            ->line('O PagSeguro rejeitou sua tentativa de pagamento.')
            ->line('Para verificar mais detalhes da transação e efetuar um novo pagamento, clique no botão abaixo:')
            ->action('Verificar pagamento', $this->url)
            ->line('Caso tenha problemas novamente com seu pagamento, crie um chamado em nosso site através do botão abaixo:')
            ->action('Abrir chamado', $this->chamadoUrl)
            ->line('A equipe WEBContabilidade agradece sua preferência :)')
            ->subject('Houve um problema com seu pagamento')
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
            'mensagem' => 'O PagSeguro rejeitou sua tentativa de pagamento.',
            'url' => $this->url
        ];
    }
}
