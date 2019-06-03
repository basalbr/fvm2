<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class MensalidadeAdjustment extends Notification implements ShouldQueue
{
    use Queueable;
    private $usuario;

    /**
     */
    public function __construct($usuario)
    {
        $this->usuario = $usuario;
    }

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
        if ($this->usuario->empresas->count() || $this->usuario->aberturasEmpresa->count()) {
            return (new MailMessage)
                ->greeting('Olá ' . $this->usuario->nome . '!')
                ->line('Queremos agradecer por ter nos confiado sua empresa :)')
                ->line('Informamos que as empresas que você cadastrou em nosso sistema continuarão com o mesmo valor de mensalidade, sem nenhum reajuste.')
                ->line('No dia 01/09, iremos realizar um reajuste de nossas mensalidades e as empresas cadastradas a partir desse dia terão valores reajustados.')
                ->line('Aproveite para convidar aquele amigo que tem interesse no sistema para se cadastrar e se beneficiar com os valores atuais.')
                ->salutation('Att,                
                WEBContabilidade :)')
                ->subject('Reajuste')
                ->from('site@webcontabilidade.com', 'WEBContabilidade');
        }
        return (new MailMessage)
            ->greeting('Olá ' . $this->usuario->nome . '!')
            ->line('Verificamos que você se cadastrou em nosso site porém não cadastrou sua empresa :(')
            ->line('Aproveite para cadastrar sua empresa em nosso sistema até dia 31/08 e garantir os preços atuais.')
            ->line('A partir do dia 01/09 nossas mensalidades serão reajustadas.')
            ->salutation('Att,            
            WEBContabilidade :)')
            ->subject('Reajuste')
            ->from('site@webcontabilidade.com', 'WEBContabilidade');
    }

}
