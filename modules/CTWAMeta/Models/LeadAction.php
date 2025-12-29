<?php

namespace Modules\CTWAMeta\Models;

use App\Models\Company;
use Illuminate\Database\Eloquent\Model;

class LeadAction extends Model
{
    protected $fillable = ['company_id', 'meta_page_id', 'ctwa_lead_id', 'action_type', 'action_payload', 'status'];
    protected $casts = ['action_payload' => 'array'];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

}
