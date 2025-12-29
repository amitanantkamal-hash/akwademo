<?php

namespace Modules\Wpbox\Models;

use App\Scopes\CompanyScope;
use Illuminate\Database\Eloquent\Model;

class WhatsappFlowsModel extends Model
{
    protected $table = 'whatsapp_flows';
    public $guarded = [];

    public function whatsAppFlowDataCount()
    {
        return $this->hasMany(WhatsAppFlowsSubmittion::class, 'flow_id', 'unique_flow_id');
    }

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

    public function viewLayout()
    {
        // Local key: unique_flow_id in flows
        // Foreign key: flow_id in layout table
        return $this->hasOne(WhatsAppFlowsViewLayout::class, 'flow_id', 'unique_flow_id');
    }
}
