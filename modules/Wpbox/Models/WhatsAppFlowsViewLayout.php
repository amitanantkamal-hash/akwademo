<?php

namespace Modules\Wpbox\Models;

use App\Scopes\CompanyScope;
use Illuminate\Database\Eloquent\Model;

class WhatsAppFlowsViewLayout extends Model
{
    protected $table = 'whatsapp_flows_view_layout';
    public $guarded = [];

    // Define any custom methods or scopes here
    protected static function booted(){
        static::addGlobalScope(new CompanyScope);

        static::creating(function ($model){
           $company_id=session('company_id',null);
            if($company_id){
                $model->company_id=$company_id;
            }
        });
    }
}
