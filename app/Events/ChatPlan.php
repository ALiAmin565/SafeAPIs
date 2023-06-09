<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ChatPlan implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $massage;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct( $massage)
    {

        $this->massage=$massage;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('ChatPlan');
    }

    public function broadcastAs()
    {
        // for listen this
        return 'ChatPlan';
    }


    public function broadcastWith()
    {

        return  [
            'Massage'=>response()->json([

            'massage'=>$this->massage,
        ])];

    }

}
