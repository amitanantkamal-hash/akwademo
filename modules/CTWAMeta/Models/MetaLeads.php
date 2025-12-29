<?php

namespace Modules\CTWAMeta\Models;

use App\Models\Company;
use Illuminate\Database\Eloquent\Model;

class MetaLeads extends Model
{
    protected $table = 'meta_leads';

    protected $fillable = [
        'company_id', 'meta_page_id', 'business_id', 'meta_account_id', 'ad_id', 
        'ad_name','campaign_id','campaign_name','platform', 'name',
        'form_id', 'leadgen_id', 'page_id', 'adgroup_id', 
        'field_data', 'received_at', 'processed', 'processed_at'
    ];
    
    protected $casts = [
        'field_data' => 'array',
        'received_at' => 'datetime',
        'processed_at' => 'datetime'
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function metaPage()
    {
        return $this->belongsTo(MetaPage::class, 'meta_page_id');
    }

    public function businessAccount()
    {
        return $this->belongsTo(MetaBusinessAccount::class, 'business_id', 'id');
    }

    public function metaAccount()
    {
        return $this->belongsTo(MetaAccount::class, 'meta_account_id');
    }
}

