<?php

namespace Modules\BotFlow\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Company;

class BotFlow extends Model
{
    use HasFactory;
    protected $table = 'bot_flows';
    protected $fillable = [
        'company_id',
        'name',
        'description',
        'flow_data',
        'is_active'
    ];
 
    /**
     * Create a new factory instance for the model.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    protected static function newFactory()
    {
        return \Modules\BotFlow\Database\Factories\BotFlow::new();
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function getFeatureSlug(): ?string
    {
        return 'bot_flow';
    }
}
