<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class NewContatoFromSite extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    private $message;

    public function __construct($mensagem)
    {
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
            ->from($this->message->get('email'), $this->message->get('nome'))
            ->replyTo($this->message->get('email'), $this->message->get('nome'))
            ->subject('Novo contato do site')
            ->markdown('emails.contato', ['nome' => $this->message->get('nome'), 'mensagem' => $this->message->get('mensagem')]);
    }
}
