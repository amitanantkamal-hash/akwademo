<?php

namespace Modules\CTWAMeta\Models;

use App\Models\Company;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MetaPage extends Model
{
    use HasFactory;

    protected $fillable = [
        'page_id',
        'company_id',
        'fb_connection_id',
        'business_id',
        'name',
        'category',
        'access_token',
        'picture_url',
        'tasks',
        'page_permissions'
    ];

    protected $casts = [
        'tasks' => 'array',
        'page_permissions' => 'array',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function connection()
    {
        return $this->belongsTo(FacebookAppConnection::class, 'fb_connection_id');
    }

    public function businessAccount()
    {
        return $this->belongsTo(MetaBusinessAccount::class, 'business_id', 'business_id');
    }
}