<?php

namespace App\Events;

use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;

class ShippingNumber
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $trackingNum;
    public $table;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($trackingNum, $table)
    {
        $this->trackingNum = $trackingNum;
        $this->table = $table;
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
