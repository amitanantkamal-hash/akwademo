<?php

namespace Modules\CTWAMeta\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CtwaMessage extends Model
{
    protected $fillable = [
        'campaign_id',
        'sender_id',
        'receiver_id',
        'message',
        'message_type',
        'received_at',
    ];

    protected $dates = ['received_at'];

    public function campaign()
    {
        return $this->belongsTo(CtwaCampaign::class, 'campaign_id');
    }
}