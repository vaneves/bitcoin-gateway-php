<?php

namespace App\Models\Entities;

use Illuminate\Database\Eloquent\Model;
use App\Models\Enum\NotificationStatus;

class Notification extends Model
{
    protected $fillable = [
        'invoice_id', 'code', 'status',
    ];

    protected $hidden = [];

    protected $dates = [
        'created_at', 'updated_at',
    ];

    public function getStatusTextAttribute()
    {
        return NotificationStatus::TEXTS[$this->attributes['status']];
    }

    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }

    public function history()
    {
        return $this->hasMany(NotificationHistory::class);
    }
}
