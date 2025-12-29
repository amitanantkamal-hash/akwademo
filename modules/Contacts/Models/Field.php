<?php

namespace Modules\Contacts\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Scopes\CompanyScope;

class Field extends Model
{
    use SoftDeletes;

    protected $table = 'custom_contacts_fields';
    public $guarded = [];
    protected static function booted(){
        static::addGlobalScope(new CompanyScope);

        static::creating(function ($model){
           $company_id=session('company_id',null);
            if($company_id){
                $model->company_id=$company_id;
            }
        });


        static::created(function ($field) {
            $company_id = auth()->user()->company->id;
            $contacts = Contact::where('company_id', $company_id)->get();

            foreach ($contacts as $contact) {
                $field->contacts()->attach($contact->id, ['value' => 'N/A']); 
            }
        });
    }

    public function contacts()
    {
        return $this->belongsToMany(
            Contact::class,
            'custom_contacts_fields_contacts',   
            'custom_contacts_field_id',         
            'contact_id'                       
        )->withPivot('value');                
    }
}
