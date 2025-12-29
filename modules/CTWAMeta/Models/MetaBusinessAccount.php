<?php

namespace Modules\CTWAMeta\Models;

use App\Models\Company;
use App\Scopes\CompanyScope;
use Illuminate\Database\Eloquent\Model;

class MetaBusinessAccount extends Model
{
    protected $fillable = [
        'business_id',
        'company_id',
        'fb_connection_id',
        'name',
        'vertical',
        'primary_page_id',
        'business_profile',
        'picture_url',
        'link',
        'raw_data'
    ];

    protected $casts = [
        'raw_data' => 'array'
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

    public function fbConnection()
    {
        return $this->belongsTo(FacebookAppConnection::class);
    }

    public function adAccounts()
    {
        return $this->hasMany(MetaAccount::class, 'business_id', 'business_id');
    }
}
