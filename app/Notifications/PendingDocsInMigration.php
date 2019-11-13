<?php

namespace App\Notifications;

use App\Models\AberturaEmpresa;
use App\Models\Empresa;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

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
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
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
        if(AberturaEmpresa::where('cnpj', $this->empresa->cnpj)->count() > 0){
            return (new MailMessage)
                ->greeting('Olá ' . $this->empresa->usuario->nome. '!')
                ->line('Sua empresa '.$this->empresa->razao_social .' foi ativada e a partir de agora você já pode acessar as funcionalidades do nosso sistema.')
                ->line('Isso ocorre pois como sua empresa é optante pelo Simples Nacional, mesmo que não tenha movimento ou ainda não possua o alvará de funcionamento, nós precisamos enviar informações mensalmente para a Receita Federal.')
                ->line('Então a partir de hoje será necessário enviar mensalmente seus documentos contábeis e documentos fiscais através das apurações abertas em nosso sistema ou informar como sem movimento.')
                ->line('Sempre que tiver alguma dúvida pode entrar em contato conosco através da opção "Atendimento" no menu ou agendar uma reunião através da opção "Reuniões".')
                ->line('Ah, e o CNPJ da sua empresa é '.$this->empresa->cnpj.'!')
                ->line('Para visualizar sua empresa, clique no botão abaixo:')
                ->action('Visualizar', $this->url)
                ->salutation('A equipe WEBContabilidade agradece sua preferência :)')
                ->subject('Empresa ativada')
                ->from('site@webcontabilidade.com', 'WEBContabilidade');
        }
        return (new MailMessage)
            ->greeting('Olá ' . $this->empresa->usuario->nome. '!')
            ->line('Sua empresa '.$this->empresa->razao_social .' foi ativada e a partir de agora você já pode acessar as funcionalidades do nosso sistema.')
            ->line('Então a partir de hoje será necessário enviar mensalmente seus documentos contábeis e documentos fiscais através das apurações abertas em nosso sistema ou informar como sem movimento.')
            ->line('Sempre que tiver alguma dúvida pode entrar em contato conosco através da opção "Atendimento" no menu ou agendar uma reunião através da opção "Reuniões".')
            ->line('Para visualizar sua empresa, clique no botão abaixo:')
            ->action('Visualizar Empresa', $this->url)
            ->salutation('A equipe WEBContabilidade agradece sua preferência :)')
            ->subject('Empresa ativada')
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
            'mensagem' => 'Sua empresa '.$this->empresa->nome_fantasia .' foi ativada e a partir de agora você já pode acessar as funcionalidades do nosso sistema.',
            'url' => $this->url
        ];
    }
}
