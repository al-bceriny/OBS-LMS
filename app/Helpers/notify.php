<?php

use App\Models\Notification;

function notify_user($user_id, $title, $message, $link = null)
{
    Notification::create([
        'user_id' => $user_id,
        'title'   => $title,
        'message' => $message,
        'link'    => $link,
    ]);
}
