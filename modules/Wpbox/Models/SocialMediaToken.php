<?php

namespace Modules\Wpbox\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SocialMediaToken extends Model {
    use HasFactory;

    protected $table = 'social_media_tokens';
    protected $guarded = [];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'company_id',
        'social_media_name',
        'name',
        'app_id',
        'access_token',
    ];

    protected $casts = [
        'company_id' => 'integer',
        'social_media_name' => 'string',
        'name' => 'string',
        'app_id' => 'string',
        'access_token' => 'string',
    ];
}
