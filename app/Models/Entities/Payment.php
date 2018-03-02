<?php

namespace App\Models\Entities;

use Illuminate\Database\Eloquent\Model;
use App\Common\Money;

class Payment extends Model
{
    protected $fillable = [
        'invoice_id', 'block', 'txid', 'value', 'received_at', 'index',
    ];

    protected $hidden = [
        'id', 'invoice_id', 'index',
    ];

    protected $dates = [
        'received_at', 'created_at', 'updated_at',
    ];

    public function getValueTextAttribute()
    {
        return Money::toBTC($this->attributes['value']);
    }

    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }
}
