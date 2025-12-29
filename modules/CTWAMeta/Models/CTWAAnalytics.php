<?php

namespace Modules\CTWAMeta\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CTWAAnalytics extends Model
{
    protected $table = 'ctwa_analytics';

    protected $casts = [
        'metrics' => 'array', // This will automatically cast to/from JSON
    ];

    protected $fillable = [
        'meta_account_id',
        'company_id',
        'date',
        'metrics'
    ];
}