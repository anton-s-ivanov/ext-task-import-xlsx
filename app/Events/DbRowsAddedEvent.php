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
    protected $userID;

    /**
     * Create a new event instance.
     */
    public function __construct($rowsAddedQty, $userID)
    {
        $this->rowsAddedQty = $rowsAddedQty;
        $this->userID = $userID;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('parsingProgressDB.user.'.$this->userID),
        ];
    }

    /**
     * Get the name of broadcast event.
     *
     * @return string
     */
    public function broadcastAs()
    {
        return 'newRowDB';
    }

    /**
     * Broadcast the data.
     *
     * @return array
     */
    public function broadcastWith()
    {
        return ['totalRowsAddedDB' => $this->rowsAddedQty];
    }
}
