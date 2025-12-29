<?php

namespace Modules\LeadManager\Models;

use App\Models\Company;
use App\Scopes\CompanyScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LeadSource extends Model
{
     protected $table = 'lead_sources';

    protected $fillable = [
        'company_id',
        'name',
        'description',
        'is_active'
    ];

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    protected static function booted()
    {
        static::addGlobalScope(new CompanyScope);

        static::creating(function ($model) {
            $company_id = session('company_id', null);
            if ($company_id) {
                $model->company_id = $company_id;
            }
        });
    }

    public function leads()
    {
        return $this->hasMany(Lead::class);
    }

    public function scopeForCompany($query, $companyId)
    {
        return $query->where('company_id', $companyId);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
