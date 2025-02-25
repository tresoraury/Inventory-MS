<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class LowStockAlert extends Notification
{
    use Queueable;

    protected $items; // Use plural if you're passing multiple items

    /**
     * Create a new notification instance.
     *
     * @param mixed $items
     * @return void
     */
    public function __construct($items)
    {
        $this->items = $items; // Assign the passed items to the property
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail']; // Adjust channels as needed
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param mixed $notifiable
     * @return MailMessage
     */
    public function toMail($notifiable)
    {
        $itemList = $this->items->map(function ($item) {
            return "{$item->designation} (ID: {$item->id}): Stock Level - {$item->stock_level}";
        })->implode("\n");
    
        return (new MailMessage)
            ->subject('Low Stock Alert')
            ->line('The following items are low in stock:')
            ->line($itemList);
    }
}
