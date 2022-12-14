<?php

namespace App\Events;

use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;

/**
 * PortingComplete
 */
class PortingComplete
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    
    public $customerId, $port;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($customerId, $port)
    {
        $this->customerId = $customerId;
        $this->port       = $port;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
