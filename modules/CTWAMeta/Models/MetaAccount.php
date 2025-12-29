<?php

// app/Modules/CTWAMeta/Models/MetaAccount.php
namespace Modules\CTWAMeta\Models;

use App\Models\Company;
use App\Scopes\CompanyScope;
use Modules\CTWAMeta\Models\CTWAAnalytics;
use Illuminate\Database\Eloquent\Model;

class MetaAccount extends Model
{
    protected $fillable = ['account_id', 'name', 'type', 'access_token', 'company_id', 'fb_connection_id', 'amount_spent','status','business_id'];

    public function analytics()
    {
        return $this->hasMany(CTWAAnalytics::class);
    }

    public function company()
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

    public function fbConnection()
    {
        return $this->belongsTo(FacebookAppConnection::class, 'fb_connection_id');
    }

    public function metaBusinessAccount()
    {
        return $this->belongsTo(MetaBusinessAccount::class, 'business_id', 'business_id');
    }
}
