<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class NewContatoFromSite extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    private $message;
    private $name;
    private $email;

    public function __construct($email, $name, $mensagem)
    {
        $this->name = $name;
        $this->email = $email;
        $this->message = $mensagem;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
            ->from('contato@webcontabilidade.com', $this->name)
            ->replyTo($this->email, $this->name)
            ->subject('Novo contato do site')
            ->markdown('emails.contato', ['name' => $this->name, 'mensagem' => $this->message]);
    }
}
