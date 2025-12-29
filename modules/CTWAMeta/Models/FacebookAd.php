<?php

namespace Modules\CTWAMeta\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FacebookAd extends Model
{
    use HasFactory;

    protected $table = 'facebook_ads';

    protected $fillable = [
        'user_id',
        'campaign_id',
        'campaign_name',
        'ad_id',
        'ad_name',
        'status',
        'ad_created_at', 
        'ad_account',
        'ad_account_id',
        'creative',
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
        return \Modules\CTWAMeta\Database\Factories\FacebookAd::new();
    }
}
