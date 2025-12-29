<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'discount_type',
        'discount_value',
        'expiration_date',
        'usage_limit',
        'usage_count',
        'applicable_plan_ids',
        'stripe_coupon_id'
    ];

    protected $casts = [
        'applicable_plan_ids' => 'array', // Convert JSON to array
        'expiration_date' => 'datetime'
    ];
}