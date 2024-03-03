<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use App\Notifications\UserTransactionNotification;

class NotificationController extends Controller
{
    public function userTransaction($user)
    {   
        $admin = User::where('roles', 'ADMIN')->first();
        $user = User::where('id', $user)->first();
        Notification::send($admin, new UserTransactionNotification($user));
    }
}
