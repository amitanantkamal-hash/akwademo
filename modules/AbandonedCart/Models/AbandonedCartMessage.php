<?php

namespace Modules\AbandonedCart\Models;

use Illuminate\Database\Eloquent\Model;

class AbandonedCartMessage extends Model
{
    protected $fillable = [
        'abandoned_cart_id','campaign_id', 'payload', 'scheduled_at', 
        'sent_at', 'status', 'response'
    ];

    protected $casts = [
        'payload' => 'array',
        'scheduled_at' => 'datetime',
        'sent_at' => 'datetime',
    ];


    public function cart()
    {
        return $this->belongsTo(AbandonedCart::class, 'abandoned_cart_id');
    }
}