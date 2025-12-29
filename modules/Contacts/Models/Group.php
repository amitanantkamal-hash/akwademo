<?php

namespace Modules\Contacts\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Scopes\CompanyScope;
use Illuminate\Support\Facades\DB;

class Group extends Model
{
    use SoftDeletes;
    
    protected $table = 'groups';
    public $guarded = [];

    public function contacts()
    {
        return $this->belongsToMany(
                Contact::class,
                'groups_contacts',
                'group_id',
                'contact_id'
            );
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

    public function deleteGroupAndContacts()
    {
        DB::transaction(function () {
            $batchSize = 5000; // Process in batches of 5000

            do {
                // Fetch contacts linked ONLY to this group
                $contactIds = DB::select("
                    SELECT c.id 
                    FROM contacts c 
                    JOIN groups_contacts gc ON gc.contact_id = c.id
                    WHERE gc.group_id = ? 
                    GROUP BY c.id 
                    HAVING COUNT(gc.group_id) = 1 
                    LIMIT ?
                ", [$this->id, $batchSize]);

                $contactIds = collect($contactIds)->pluck('id')->toArray();

                if (!empty($contactIds)) {
                    // Soft delete contacts
                    DB::table('contacts')
                        ->whereIn('id', $contactIds)
                        ->update(['deleted_at' => now()]);

                    // Delete their associations
                    DB::table('groups_contacts')
                        ->whereIn('contact_id', $contactIds)
                        ->delete();
                }
            } while (count($contactIds) > 0);

            DB::table('groups_contacts')->where('group_id', $this->id)->delete();
            $this->delete();
        });
    }
}
