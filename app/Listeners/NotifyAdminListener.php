<?php

namespace App\Listeners;

use App\Models\User;
use App\Events\TransactionEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Notification;
use App\Notifications\UserTransactionNotification;

class NotifyAdminListener implements ShouldQueue
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(TransactionEvent $event)
    {   
        $admin = $event->getAdmin();
        $user = $event->getUser();
   
        Notification::send($admin, new UserTransactionNotification($user));
    }
}
