<?php

namespace Modules\LeadManager\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LeadFollowup extends Model
{
    protected $fillable = ['lead_id', 'scheduled_at', 'notes', 'reminder_sent'];

    protected $casts = [
        'scheduled_at' => 'datetime',
        'reminder_sent' => 'boolean'
    ];

    public function lead(): BelongsTo
    {
        return $this->belongsTo(Lead::class);
    }
}