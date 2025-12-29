<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Partner extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'phone',
        'email',
        'website',
        'business_name',
        'gst_number',
        'pan_number',
        'billing_address',
        'allowed_customer_creation',
        'is_active',
        'logo',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}