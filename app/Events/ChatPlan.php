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
    public $plan;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($massage,$plan)
    {

        $this->massage=$massage;
        // dd( $this->plan=$plan);
        $this->plan=$plan;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        // return new Channel('recommendation.'.$this->plan_name);

        // dd('chat.'.$this->plan);
        return new Channel('chat.'.$this->plan);
    }

    public function broadcastAs()
    {
                 // for listen this
                // return 'recommendation.'.$this->plan_name;
            //    dd('chat.'.$this->plan);
        return 'chat.'.$this->plan;
    }


    public function broadcastWith()
    {


        $media = $this->massage->media;
        return [
            'massage' => $this->massage,
            'media' => $media,
        ];

        // return  [
        //     'Massage'=>response()->json([

        //     'massage'=>$this->massage,
        // ])];

    }

}
