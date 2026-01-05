<?php

namespace App\Events;

use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

// app/Events/OrderPaidEvent.php
class OrderPaidEvent
{
    use Dispatchable;
    use SerializesModels;

    public function __construct(public Order $order)
    {
        return [
            new PrivateChannel('channel-name'),
        ];
    }
}
