<?php

namespace App\Events;

use App\Models\Mylead;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Broadcasting\InteractsWithSockets;

/**
 * Event fired when a lead is booked.
 *
 * @property-read \App\Models\Mylead $lead
 */
class LeadBooked implements ShouldBroadcast
{
    use Dispatchable, SerializesModels, InteractsWithSockets;

    public Mylead $lead;

    /**
     * Create a new event instance.
     *
     * @param  \App\Models\Mylead  $lead
     * @return void
     */
    public function __construct(Mylead $lead)
    {
        $this->lead = $lead;
    }

    /**
     * Get the channels the event should broadcast on.
     */
    public function broadcastOn()
    {
        return ['private-lead.' . $this->lead->id];
    }

    public function broadcastAs()
    {
        return 'LeadBooked';
    }
}
