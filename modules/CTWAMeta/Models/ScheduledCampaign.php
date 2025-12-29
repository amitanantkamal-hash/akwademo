<?php

namespace Modules\CTWAMeta\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ScheduledCampaign extends Model
{
    use HasFactory;

    protected $table = 'scheduled_campaigns';

    protected $guarded = [];

    /**
     * Create a new factory instance for the model.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    protected static function newFactory()
    {
        //return \Modules\CTWAMeta\Database\Factories\ScheduledCampaign::new();
    }
}
