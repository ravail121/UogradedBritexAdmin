<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;

class BusinessVerificationRejected
{

	/**
	 *
	 */
    use Dispatchable, InteractsWithSockets, SerializesModels;

	/**
	 * @var
	 */
    public $bizHash;

	/**
	 * @var
	 */
    public $message;

	/**
	 * @var
	 */
    public $subject;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($bizHash, $message, $subject)
    {
        $this->bizHash = $bizHash;
        $this->message = $message;
        $this->subject = $subject;
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
