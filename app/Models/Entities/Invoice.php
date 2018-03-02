<?php

namespace App\Models\Entities;

use Illuminate\Database\Eloquent\Model;
use App\Models\Enum\InvoiceStatus;
use App\Common\Money;

class Invoice extends Model
{
    protected $fillable = [
        'user_id', 
        'code', 
        'address', 
        'reference', 
        'total', 
        'fee', 
        'status', 
        'notification_url', 
        'buyer_name', 
        'buyer_email',
    ];

    protected $hidden = [
        'id', 'user_id', 'address', 'notification_url', 'buyer_name', 'buyer_email',
    ];

    protected $dates = [
        'created_at', 'updated_at',
    ];

    public static function boot()
    {
        static::created(function ($model) {
            try {
                StatusHistory::create([
                    'invoice_id' => $model->id,
                    'status' => $model->status,
                ]);
            } catch (\Exception $e) {}
        });

        static::updated(function ($model) {
            try {
                StatusHistory::create([
                    'invoice_id' => $model->id,
                    'status' => $model->status,
                ]);
            } catch (\Exception $e) {}
        });
        
        parent::boot();
    }

    public function getStatusTextAttribute()
    {
        return InvoiceStatus::TEXTS[$this->attributes['status']];
    }

    public function getTotalTextAttribute()
    {
        return Money::toBTC($this->attributes['total']);
    }

    public function getFeeTextAttribute()
    {
        return Money::toBTC($this->attributes['fee']);
    }

    public function getNetValueTextAttribute()
    {
        return Money::toBTC($this->attributes['total'] - $this->attributes['fee']);
    }

    public function getBuyerAttribute()
    {
        return [
            'name' => $this->attributes['buyer_name'],
            'email' => $this->attributes['buyer_email'],
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }

    public function statusHistories()
    {
        return $this->hasMany(StatusHistory::class);
    }

    public function items()
    {
        return $this->hasMany(Item::class);
    }

    public function isPaid()
    {
        return $this->status == InvoiceStatus::PAID;
    }

    public function isExpired()
    {
        return $this->created_at->diffInDays(\Carbon\Carbon::now()) > 3;
    }
}
