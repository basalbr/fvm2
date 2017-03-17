<?php

namespace App\Events\AberturaEmpresa;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class UserSentMessage
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $aberturaEmpresa;
    public $mensagem;

    /**
     * Create a new event instance.
     */
    public function __construct(AberturaEmpresa $aberturaEmpresa, ChamadoMensagem $mensagem)
    {
        $this->aberturaEmpresa = $aberturaEmpresa;
        $this->mensagem = $mensagem;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
