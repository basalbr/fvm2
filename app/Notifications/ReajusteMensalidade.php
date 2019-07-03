<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ReajusteMensalidade extends Notification implements ShouldQueue
{
    use Queueable;
    private $mensalidadeAtual;
    private $novoValor;

    /**
     */
    public function __construct($mensalidadeAtual, $novoValor)
    {
        $this->mensalidadeAtual = $mensalidadeAtual;
        $this->novoValor = $novoValor;
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
                ->greeting('Olá ' . $notifiable->nome . '!')
                ->line('A partir de 01/07/2019 nós estaremos reajustando o valor das mensalidades antigas em nosso sistema para que fiquem de acordo com os planos atuais.')
                ->line('Dessa forma a mensalidade da empresa '.$this->mensalidadeAtual->empresa->razao_social.' passará de '. $this->mensalidadeAtual->getValor().' para o valor de R$'.number_format($this->novoValor, 2, ',','.').'.')
                ->line('Esse novo valor contempla seu plano de '.$this->mensalidadeAtual->qtde_funcionario.' funcionários e '.$this->mensalidadeAtual->qtde_documento_fiscal.' documentos fiscais emitidos/recebidos mensalmente.')
                ->line('Desde que abrimos há 3 anos nunca houve um único reajuste mesmo com várias melhorias em nosso sistema e em nossa equipe.')
                ->line('Portanto o motivo desse reajuste é para contemplar essas melhorias assim como continuar implementando novas funcionalidades e oferecendo um serviço cada vez melhor para você.')
                ->line('Caso tenha dúvidas ou alguma questão com relação à esse assunto ou queira alterar seu plano, você pode abrir um chamado que ficaremos felizes em conversar contigo.')
                ->salutation('Att,                
                WEBContabilidade :)')
                ->subject('Reajuste na mensalidade')
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
            'mensagem' => 'A mensalidade da empresa '.$this->mensalidadeAtual->empresa->razao_social.' será reajusta para '.number_format($this->novoValor, 2, ',','.').' em 01/07/2019.',
            'url' => route('dashboard')
        ];
    }

}
