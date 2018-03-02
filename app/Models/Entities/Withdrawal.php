<?php

namespace App\Models\Entities;

use Illuminate\Database\Eloquent\Model;
use App\Models\Enum\WithdrawalStatus;
use App\Common\Money;

class Withdrawal extends Model
{
    protected $fillable = [
        'user_id', 
    ];

    protected $hidden = [];

    protected $dates = [
        'created_at', 'updated_at',
    ];

    public function getStatusTextAttribute()
    {
        return WithdrawalStatus::TEXTS[$this->attributes['status']];
    }

    public function getValueTextAttribute()
    {
        return Money::toBTC($this->attributes['value']);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
