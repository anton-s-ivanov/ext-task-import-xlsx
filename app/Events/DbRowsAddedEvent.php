<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class DbRowsAddedEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;


    protected $rowsAddedQty;

    /**
     * Create a new event instance.
     */
    public function __construct($rowsAddedQty)
    {
        $this->rowsAddedQty = $rowsAddedQty;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            // new PrivateChannel('channel-name'),
            new Channel('public.test.chanel'),
        ];
    }

    /**
     * Get the name of broadcast event.
     *
     * @return string
     */
    public function broadcastAs()
    {
        return 'db_rows_added';
    }

    /**
     * Broadcast the data.
     *
     * @return string
     */
    public function broadcastWith()
    {
        return ['progressRows' => $this->rowsAddedQty];
    }
}
