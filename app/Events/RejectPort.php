<?php

namespace App\Events;

use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;

class RejectPort
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $customerId;
    public $subject;
    public $message;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($customerId, $subject, $message)
    {
        $this->customerId = $customerId;
        $this->subject    = $subject;
        $this->message    = $message;
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
