<?php

namespace App\Notifications;

use App\Models\Empresa;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PendingDocsInMigration extends Notification implements ShouldQueue
{
    use Queueable;
    private $empresa;
    private $url;

    /**
     * Create a new notification instance.
     *
     * @param Empresa $empresa
     */
    public function __construct(Empresa $empresa)
    {
        $this->empresa = $empresa;
        $this->url = route('showEmpresaToUser', [$this->empresa->id]);
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
            ->greeting('Olá ' . $this->empresa->usuario->nome . '!')
            ->line('Precisamos de alguns documentos para seu processo de migração.')
            ->line('Para verificar os documentos que precisamos, clique no botão abaixo:')
            ->action('Visualizar', $this->url)
            ->salutation('A equipe WEBContabilidade agradece sua preferência :)')
            ->subject('Documentos pendentes para migração')
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
            'mensagem' => 'Precisamos de alguns documentos para seu processo de migração.',
            'url' => $this->url
        ];
    }
}
