<?php

namespace Modules\SmartClick\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SmartClickTrigger extends Model
{
    use HasFactory;

    protected $fillable = ['monitor_id', 'keyword'];
    
    public function monitor(): BelongsTo
    {
        return $this->belongsTo(SmartClickMonitor::class);
    }
}