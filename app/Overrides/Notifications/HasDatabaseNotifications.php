<?php
/**
 * Created by PhpStorm.
 * User: Junior
 * Date: 18/03/2017
 * Time: 21:59
 */

namespace App\Overrides\Notification;


use App\Models\Notificacao;

trait HasDatabaseNotifications
{
    /**
     * Get the entity's notifications.
     */
    public function notifications()
    {
        return $this->morphMany(Notificacao::class, 'notifiable')
            ->orderBy('created_at', 'desc');
    }

    /**
     * Get the entity's read notifications.
     */
    public function readNotifications()
    {
        return $this->notifications()
            ->whereNotNull('read_at');
    }

    /**
     * Get the entity's unread notifications.
     */
    public function unreadNotifications()
    {
        return $this->notifications()
            ->whereNull('read_at');
    }
}
