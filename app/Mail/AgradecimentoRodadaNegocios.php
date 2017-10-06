<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Queue\SerializesModels;

/**
 * Class AgradecimentoRodadaNegocios
 * @package App\Mail
 */
class AgradecimentoRodadaNegocios extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */

    private $nome;

    public function __construct($nome)
    {
        $this->nome = $nome;
    }

    /**
     * Build the message.
     *
     */
    public function build()
    {
        return $this->subject('Agradecimento')->from('contato@webcontabilidade.com', 'Aldir Baseggio Junior')->markdown('emails.rodada-negocios',['nome'=>$this->nome]);
    }
}
