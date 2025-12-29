<?php

namespace Modules\CTWAMeta\Models;

use App\Models\Company;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CTWAReferral extends Model
{
    use HasFactory;

    protected $table = 'ctwa_referrals';

    protected $fillable = [
        'company_id',
        'phone',
        'ad_id',
        'source_url',
        'headline',
        'body',
        'media_url'
    ];

    // Relationship with Company
    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}