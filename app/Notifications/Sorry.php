<?php

namespace App\Notifications;

use App\Models\OrdemPagamento;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class Sorry extends Notification
{
    use Queueable;

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
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
            ->line('Visando melhorar a sua experiência com nossos serviços, realizamos a contratação de um servidor mais veloz no dia 23/10/2018.')
            ->line('Por algum motivo que nossa hospedagem não soube informar, na madrugada do dia 28/10/2018 foi realizada a redefinição de nossa conta (inclusive nossos backups) de volta para o dia 23, que foi a data de contratação do novo servidor.')
            ->line('Dessa forma nós acabamos perdendo todas as suas interações em nosso servidor feitas a partir do dia 23.')
            ->line('Caso tenha feito alguma das solicitações abaixo, pedimos que abra um chamado ou envie um e-mail para contato@webcontabilidade.com para que possamos dar sequência na solicitação ou para que possamos te auxiliar:')
            ->line('* Pagamentos efetuados;')
            ->line('* Alterações/Transformações;')
            ->line('* Encerramento;')
            ->line('* Abertura de empresa;')
            ->line('* Cadastro de funcionários;')
            ->line('* Novos chamados ou novas mensagens;')
            ->line('* Envio de certificado digital.')
            ->line('Pedimos as mais sinceras desculpas pelo ocorrido, em dois anos de atividades é a primeira vez que isso ocorre e garantimos que as providências necessárias foram tomadas para que nunca mais ocorra.')
            ->salutation('Equipe WEBContabilidade')
            ->subject('Ocorreu um problema em nosso sistema')
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
            'mensagem' => 'Verificamos que existem apurações em aberto no nosso sistema que requerem sua atenção.'
        ];
    }
}
