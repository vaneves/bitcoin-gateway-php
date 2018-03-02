<?php

namespace App\Models\Entities;

use Illuminate\Database\Eloquent\Model;

class NotificationHistory extends Model
{
    protected $fillable = [
        'notification_id', 'code',
    ];

    protected $dates = [
        'created_at', 'updated_at',
    ];

    public function notification()
    {
        return $this->belongsTo(Notification::class);
    }
}
