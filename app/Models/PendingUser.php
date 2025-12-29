<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PendingUser extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'name_company',
        'email',
        'phone',
        'country_code',
        'password',
        'is_optin',
        'email_verification_token'
    ];
}
