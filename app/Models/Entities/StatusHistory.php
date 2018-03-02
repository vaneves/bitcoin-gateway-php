<?php

namespace App\Models\Entities;

use Illuminate\Database\Eloquent\Model;

class StatusHistory extends Model
{
    protected $fillable = [
        'invoice_id', 'status',
    ];

    protected $dates = [
        'created_at', 'updated_at',
    ];

    public function getStatusTextAttribute()
    {
        return \App\Models\Enum\InvoiceStatus::TEXTS[$this->attributes['status']];
    }

    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }
}
