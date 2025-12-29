<?php

namespace Modules\CTWAMeta\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MetaAd extends Model
{
    use HasFactory;

    protected $table = 'meta_ads';
    protected $fillable = [
        'user_id',
        'meta_adset_id',
        'meta_campaign_id',
        'ad_id',
        'creative_id',
        'name',
        'status',
        'creative',
        'last_synced_at',
        'raw_response',
    ];

    protected $casts = [
        'creative' => 'array',
    ];
    
    // Optional: define relationship
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Create a new factory instance for the model.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    protected static function newFactory()
    {
        return \Modules\CTWAMeta\Database\Factories\MetaAd::new();
    }
}
