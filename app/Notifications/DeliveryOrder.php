<?php

namespace App\Notifications;

use App\Models\DeliveryOrder as ModelsDeliveryOrder;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class DeliveryOrder extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */

    protected ModelsDeliveryOrder $deliveryOrder;

    public function __construct($deliveryOrder)
    {
        $this->deliveryOrder = $deliveryOrder;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'counter' => $this->deliveryOrder->counter->name,
            'order_date' => $this->deliveryOrder->order_date,
            'order_time' => $this->deliveryOrder->order_time,
        ];
    }
}
