<?php
/**
 * Created by PhpStorm.
 * User: Junior
 * Date: 18/03/2017
 * Time: 21:59
 */

namespace App\Overrides\Notifications;


trait Notifiable
{
    use HasDatabaseNotifications, RoutesNotifications;
}