<?php

namespace App\Notifications;

use App\Models\Empresa;
use App\Models\Mensagem;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class LimiteDocumentosUltrapassado extends Notification implements ShouldQueue
{
    use Queueable;

    private $limite;
    private $empresa;
    private $qtdeEnviado;
    private $competencia;
    private $url;

    /**
     * MessageSent constructor.
     * @param Empresa $empresa
     * @param int $limite
     * @param int $qtdeEnviado
     * @param string $competencia
     */
    public function __construct(Empresa $empresa, int $limite, int $qtdeEnviado, string $competencia)
    {
        $this->empresa = $empresa;
        $this->limite = $limite;
        $this->qtdeEnviado = $qtdeEnviado;
        $this->competencia = $competencia;
        $this->url = route('showEmpresaToAdmin', $empresa->id);
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param mixed $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->greeting('Olá ' . $notifiable->nome . '!')
            ->line('A empresa ' . $this->empresa->razao_social . ' ultrapassou o limite de '.$this->limite.' documentos fiscais ao enviar '.$this->qtdeEnviado.' documentos fiscais na competência de '.$this->competencia.'.')
            ->line('Para ver essa empresa, clique no botão abaixo.')
            ->action('Visualizar', $this->url)
            ->salutation('A equipe WEBContabilidade agradece sua preferência :)')
            ->subject('Limite de documentos fiscais ultrapassado')
            ->from('site@webcontabilidade.com', 'WEBContabilidade');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'mensagem' => 'A empresa ' . $this->empresa->razao_social . ' ultrapassou o limite de '.$this->limite.' documentos fiscais ao enviar '.$this->qtdeEnviado.' documentos fiscais na competência de '.$this->competencia.'.',
            'url' => $this->url
        ];
    }

}
