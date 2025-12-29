<?php

namespace Modules\SmartClick\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SmartClickAction extends Model
{
    use HasFactory;

    protected $fillable = [
        'monitor_id', 'action_type', 'action_value', 
        'delay_minutes', 'order'
    ];
    
    public function monitor(): BelongsTo
    {
        return $this->belongsTo(SmartClickMonitor::class);
    }
}