<?php

namespace App\Models\Entities;

use Illuminate\Database\Eloquent\Model;
use App\Common\Money;

class Item extends Model
{
    protected $fillable = [
        'invoice_id', 'name', 'price', 'amount',
    ];

    protected $hidden = [];

    protected $dates = [
        'created_at', 'updated_at',
    ];

    public function getPriceTextAttribute()
    {
        return Money::toBTC($this->attributes['price']);
    }

    public function getTotalAttribute()
    {
        return $this->attributes['price'] * $this->attributes['amount'];
    }

    public function getTotalTextAttribute()
    {
        return Money::toBTC($this->attributes['price'] * $this->attributes['amount']);
    }

    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }
}
