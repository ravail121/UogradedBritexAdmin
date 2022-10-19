<?php

namespace App\Events;

use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;

class SubcriptionStatusChanged
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $subscriptionId;
    public $subStatus;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($subscriptionId, $subStatus = false)
    {
        $this->subscriptionId = $subscriptionId;
        $this->subStatus      = $subStatus;
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
