<?php

namespace Modules\Wpbox\Models;

use Illuminate\Database\Eloquent\Model;
use App\Scopes\CompanyScope;

class FileManager extends Model
{
    protected $table = 'files';
    public $guarded = [];

    /**
     * Create a new factory instance for the model.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */

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
