<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class BroadcastAnnouncement extends Notification
{
    use Queueable;

    protected string $title;
    protected string $type;
    protected string $body;

    public function __construct(string $title, string $type, string $body)
    {
        $this->title = $title;
        $this->type = $type;
        $this->body = $body;
    }

    public function via($notifiable)
    {
        return ['database']; // التخزين في قاعدة البيانات
    }

    public function toArray($notifiable)
    {
        return [
            'title' => $this->title,
            'type'  => $this->type,
            'body'  => $this->body,
        ];
    }
}
