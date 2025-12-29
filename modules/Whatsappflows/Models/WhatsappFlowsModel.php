<?php

namespace Modules\WhatsappFlows\Models;

use App\Scopes\CompanyScope;
use Illuminate\Database\Eloquent\Model;
use Modules\Wpbox\Models\WhatsAppFlowsViewLayout;

class WhatsappFlowsModel extends Model
{
    protected $table = 'whatsapp_flows';
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

    public function viewLayout()
    {
        return $this->hasOne(WhatsAppFlowsViewLayout::class, 'flow_id', 'flow_id');
    }
}
