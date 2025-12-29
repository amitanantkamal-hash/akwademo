<?php

namespace Modules\LeadManager\Models;

use App\Models\Company;
use App\Models\User;
use App\Scopes\CompanyScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\Contacts\Models\Contact;

class Lead extends Model
{
    protected $fillable = [
        'company_id',
        'contact_id',
        'agent_id',
        'source',
        'source_id',
        'stage',
        'next_followup_at',
        'notifications'
    ];

    protected $casts = [
        'next_followup_at' => 'datetime',
        'notifications' => 'boolean'
    ];

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function contact(): BelongsTo
    {
        return $this->belongsTo(Contact::class);
    }

    public function agent(): BelongsTo
    {
        return $this->belongsTo(User::class, 'agent_id');
    }

    public function notes(): HasMany
    {
        return $this->hasMany(LeadNote::class);
    }

    public function followups(): HasMany
    {
        return $this->hasMany(LeadFollowup::class);
    }

    public function scopeForCompany($query, $companyId)
    {
        return $query->where('company_id', $companyId);
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

    public function scopeWithContactData($query)
    {
        return $query->with('contact');
    }

    public function source()
    {
        return $this->belongsTo(LeadSource::class, 'source_id')->withDefault([
            'name' => 'Not specified',
        ]);
    }

    public function getSourceNameAttribute()
{
    return $this->source?->name ?? 'Not specified';
}

    public function nextFollowup()
    {
        return $this->followups()
            ->where('scheduled_at', '>=', now()) // only future follow-ups
            ->orderBy('scheduled_at', 'asc') // earliest first
            ->first();
    }
}
