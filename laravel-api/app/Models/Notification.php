<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $table = 'notifications';
    protected $primaryKey = 'notification_id';

    protected $fillable = [
        'notification_title',
        'notification_message',
        'notification_date',
        'notification_read',
        'notify_user',
    ];
}
