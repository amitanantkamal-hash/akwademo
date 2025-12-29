<?php

namespace Modules\CTWAMeta\Models;

use App\Models\Company;
use Illuminate\Database\Eloquent\Model;

class FacebookForm extends Model
{
    protected $fillable = ['company_id', 'form_id', 'meta_page_id', 'name', 'created_time', 'questions', 'webhook_url'];

    protected $casts = [
        'questions' => 'array',
        'created_time' => 'datetime',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function metaPage()
    {
        return $this->belongsTo(MetaPage::class, 'meta_page_id', 'page_id');
    }
}
