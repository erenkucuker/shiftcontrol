<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ScheduleCreated implements ShouldBroadcast 
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $schedule;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($schedule)
    {
        $this->schedule = $schedule;
    }
    

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('schedule-channel');
    }
    public function broadcastAs()
    {
        return 'ScheduleCreated';
    }

    public function broadcastWith()
    {
        return [
            'schedule' => $this->schedule,
            'message' => 'Schedule Created'
        ];
    }
}
