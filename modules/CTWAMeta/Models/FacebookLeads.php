<?php

namespace Modules\CTWAMeta\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FacebookLeads extends Model
{
    use HasFactory;
    protected $table = 'facebook_leads';

    protected $guarded = [];


    /**
     * Create a new factory instance for the model.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
}
