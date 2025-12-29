<?php

namespace Modules\SmartClick\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Contacts\Models\Contact;

class SmartClickSchedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'contact_id', 'monitor_id', 'action_id',
        'scheduled_at', 'is_completed', 'completed_at'
    ];
    
    protected $casts = [
        'scheduled_at' => 'datetime',
        'completed_at' => 'datetime',
    ];
    
    public function contact(): BelongsTo
    {
        return $this->belongsTo(Contact::class);
    }
    
    public function monitor(): BelongsTo
    {
        return $this->belongsTo(SmartClickMonitor::class);
    }
    
    public function action(): BelongsTo
    {
        return $this->belongsTo(SmartClickAction::class);
    }
}