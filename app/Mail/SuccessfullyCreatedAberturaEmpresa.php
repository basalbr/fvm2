<?php

namespace App\Mail;

use App\Models\AberturaEmpresa;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SuccessfullyCreatedAberturaEmpresa extends Mailable
{
    use Queueable, SerializesModels;
    public $aberturaEmpresa;
    public $url;

    /**
     * Create a new message instance.
     *
     * @param AberturaEmpresa $aberturaEmpresa
     */
    public function __construct(AberturaEmpresa $aberturaEmpresa)
    {
        $this->aberturaEmpresa = $aberturaEmpresa;
        $this->url = route('showAberturaEmpresaToUser', [$this->aberturaEmpresa->id]);
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $this->to($this->aberturaEmpresa->usuario->email)
            ->from('site@webcontabilidade.com', 'WEBContabilidade')
            ->markdown('emails.aberturaEmpresa.succesfullyCreated');
    }
}
