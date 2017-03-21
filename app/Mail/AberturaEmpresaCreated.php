<?php

namespace App\Mail;

use App\Models\AberturaEmpresa;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AberturaEmpresaCreated extends Mailable
{
    use Queueable, SerializesModels;
    private $aberturaEmpresa;

    /**
     * Create a new message instance.
     *
     */
    public function __construct(AberturaEmpresa $aberturaEmpresa)
    {
        $this->aberturaEmpresa = $aberturaEmpresa;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->to($this->aberturaEmpresa->usuario->email)
            ->from('site@webcontabilidade.com', 'WEBContabilidade')
            ->view('emails.nova-abertura-empresa', ['nome' => $this->aberturaEmpresa->usuario->nome, 'id_empresa' => $this->aberturaEmpresa->id]);
    }
}
