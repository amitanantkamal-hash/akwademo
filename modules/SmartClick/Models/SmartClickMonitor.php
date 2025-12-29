<?php

namespace Modules\SmartClick\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SmartClickMonitor extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'is_active'];
    
    public function actions(): HasMany
    {
        return $this->hasMany(SmartClickAction::class);
    }
    
    public function schedules(): HasMany
    {
        return $this->hasMany(SmartClickSchedule::class);
    }
    
    public function triggers(): HasMany
    {
        return $this->hasMany(SmartClickTrigger::class);
    }
}