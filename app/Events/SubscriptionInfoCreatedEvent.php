<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

use App\Models\Subscription_Info;

class SubscriptionInfoCreatedEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $subscription_Info;

    /**
     * Create a new event instance.
     */
    public function __construct(Subscription_Info $subscription_Info)
    {
        $this->subscription_Info = $subscription_Info;
    }

}
