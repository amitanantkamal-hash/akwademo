<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Modules\Catalogs\Models\Order;

class NewOrderReceived implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $order;

    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    public function broadcastOn()
    {
        return new Channel('orders');
    }

    public function broadcastWith()
    {
        return [
            'id' => $this->order->id,
            'reference_id' => $this->order->reference_id,
            'phone_number' => $this->order->phone_number,
            'user_name' => $this->order->user_name,
            'total' => number_format($this->order->subtotal_value / $this->order->subtotal_offset + ($this->order->shipping_cast ?? 0), 2),
            'created_at' => $this->order->created_at->format('d-m-Y h:i A'),
            'url' => route('Catalog.itemIndex', $this->order->id)
        ];
    }
}