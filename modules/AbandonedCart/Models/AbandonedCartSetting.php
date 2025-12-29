<?php

namespace Modules\AbandonedCart\Models;

use App\Models\Company;
use App\Scopes\CompanyScope;
use Illuminate\Database\Eloquent\Model;

class AbandonedCartSetting extends Model
{
    protected $fillable = ['company_id', 'enabled', 'campaign_ids', 'schedule_days', 'schedule_times', 'max_reminders'];

    protected $casts = [
        'enabled' => 'boolean',
        'campaign_ids'   => 'array',
        'schedule_days' => 'array',
        'schedule_times' => 'array',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    protected static function booted()
    {
        static::addGlobalScope(new CompanyScope());

        static::creating(function ($model) {
            $company_id = session('company_id', null);
            if ($company_id) {
                $model->company_id = $company_id;
            }
        });
    }
}
