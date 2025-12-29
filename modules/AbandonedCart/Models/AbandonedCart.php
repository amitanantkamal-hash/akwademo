<?php

namespace Modules\AbandonedCart\Models;

use App\Models\Company;
use App\Scopes\CompanyScope;
use Illuminate\Database\Eloquent\Model;

class AbandonedCart extends Model
{
     protected $fillable = [
        'company_id', 'platform', 'cart_id', 'customer_name', 
        'customer_phone', 'cart_contents', 'cart_total', 'status',
        'abandoned_at', 'recovered_at'
    ];

    protected $casts = [
        'cart_contents' => 'array',
        'abandoned_at' => 'datetime',
        'recovered_at' => 'datetime',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function messages()
    {
        return $this->hasMany(AbandonedCartMessage::class);
    }

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