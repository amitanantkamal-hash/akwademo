<?php

namespace App\Models;

use App\Traits\HasConfig;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Plans extends Model
{
    use HasConfig;
    use HasFactory;
    use SoftDeletes;

    protected $modelName = "App\Models\Plan";

    protected $table = 'plan';

    protected $guarded = [];


    public function subscriptions(): HasMany
    {
        return $this->hasMany(Subscription_Info::class);
    }

    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }


    public static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            // $model->created_by         = auth()->user() ? auth()->user()->id : null;
            $model->created_at         = date('Y-m-d H:i:s');
        });
        static::updating(function ($model) {
            // $model->created_by         = auth()->user() ? auth()->user()->id : null;
            $model->updated_at         = date('Y-m-d H:i:s');
        });
    }
}
