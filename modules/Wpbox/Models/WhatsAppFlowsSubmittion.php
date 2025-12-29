<?php

namespace Modules\Wpbox\Models;

use App\Models\Company;
use App\Scopes\CompanyScope;
use Illuminate\Database\Eloquent\Model;

class WhatsAppFlowsSubmittion extends Model
{
    protected $table = 'whatsapp_flows_form_submittion';
    public $guarded = [];

    // Define any custom methods or scopes here
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

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    // Add flow() as well if not defined yet
    public function flow()
    {
        // Local key: flow_id in submissions
        // Foreign key: unique_flow_id in flows
        return $this->belongsTo(WhatsappFlowsModel::class, 'flow_id', 'unique_flow_id');
    }
}
