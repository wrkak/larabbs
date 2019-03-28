<?php

namespace App\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\DatabaseNotification;
use JPush\Client;


class PushNotification
{

    protected $client;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
         $this->client = $client;
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
         if (app()->environment('local')) {
            return;
        }

        $user = $notification->notifiable;

        // 没有 registration_id 的不同推送
        if (!$user->registration_id) {
            return;
        }

        // 推送消息
        $this->client->push()
            ->setPlatform(['ios'])
            ->addRegistrationId($user->registration_id)
            ->iosNotification(strip_tags($notification->data['reply_content']), [
                'sound' => 'sound',
                'badge' => '+1',
            ])
            ->send();
    }
}
