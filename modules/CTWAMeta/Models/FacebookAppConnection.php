<?php

namespace Modules\CTWAMeta\Models;

use App\Models\Company;
use App\Scopes\CompanyScope;
use Illuminate\Database\Eloquent\Model;

class FacebookAppConnection extends Model
{
    protected $fillable = [
        'company_id', 'fb_user_id', 'access_token', 
        'long_lived_token', 'token_expires_at', 'ad_accounts','webhook_secret','webhook_url'
    ];
    
    protected $casts = [
        'ad_accounts' => 'array',
        'token_expires_at' => 'datetime'
    ];
    
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
    
    public function metaAccounts()
    {
        return $this->hasMany(MetaAccount::class, 'company_id', 'fb_connection_id');
    }

    public function metaBusinessAccounts()
    {
        return $this->hasMany(MetaBusinessAccount::class, 'fb_connection_id');
    }
}