<?php

namespace App\Models;

use App\Traits\HasConfig;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Modules\Wpbox\Models\SocialMediaToken;
use App\Traits\HasCredit;

class Company extends MyModel
{
    use HasConfig;
    use HasFactory;
    use SoftDeletes;
    use HasCredit;

    protected $modelName = 'App\Models\Company';

    protected $guarded = [];

    protected $imagePath = '/uploads/companies/';

    /**
     * Get the user that owns the company.
     */
    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }

    public function getAliasAttribute()
    {
        return $this->subdomain;
    }

    public function getPlanAttribute()
    {
        $planInfo = [
            'plan' => null,
            'canMakeNewOrder' => false,
            'canAddNewItems' => false,
            'itemsMessage' => '',
            'itemsAlertType' => 'success',
            'ordersMessage' => '',
            'ordersAlertType' => 'success',
        ];

        //Find the plan
        $currentPlan = Plans::withTrashed()->find($this->user->mplanid());
        if ($currentPlan == null) {
            //Make artificial plan - usefull when migrating the system  - or wrong free plan id
            $currentPlan = new Plans();
            $currentPlan->name = __('No plan found');
            $currentPlan->price = 0;
            $currentPlan->limit_items = 0;
            $currentPlan->enable_ordering = 1;
            $currentPlan->limit_orders = 0;
            $currentPlan->period = 1;
        }
        $planInfo['plan'] = $currentPlan->toArray();

        //Pure SaaS
        $planInfo['ordersMessage'] = $currentPlan->name . ' - ' . rtrim(money($currentPlan['price'], config('settings.cashier_currency'), config('settings.do_convertion', true))->format(), '.00') . '/' . ($currentPlan['period'] == 1 ? __('m') : __('y'));
        $planInfo['itemsMessage'] = $currentPlan->features;

        $plugins = $currentPlan->getConfig('plugins', null);

        if ($plugins) {
            $planInfo['allowedPluginsPerPlan'] = json_decode($plugins, false);
        } else {
            $planInfo['allowedPluginsPerPlan'] = null;
        }

        return $planInfo;
    }

    public function getLinkAttribute()
    {
        if (config('settings.wildcard_domain_ready')) {
            //As subdomain
            return str_replace('://', '://' . $this->subdomain . '.', config('app.url', ''));
        } else {
            //As link
            return route('vendor', $this->subdomain);
        }
    }

    public function getLogomAttribute()
    {
        return $this->getImage($this->logo, config('global.company_details_image'));
    }

    public function getLogowideAttribute()
    {
        return $this->getImage($this->getConfig('resto_wide_logo', null), '/default/company_wide.png', '_original.png');
    }

    public function getLogowidedarkAttribute()
    {
        return $this->getImage($this->getConfig('resto_wide_logo_dark', null), '/default/company_wide_dark.png', '_original.png');
    }

    public function getIconAttribute()
    {
        return $this->getImage($this->logo, str_replace('_large.jpg', '_thumbnail.jpg', config('global.company_details_image')), '_thumbnail.jpg');
    }

    public function getCovermAttribute()
    {
        return $this->getImage($this->cover, config('global.company_details_cover_image'), '_cover.jpg');
    }

    public function staff(): HasMany
    {
        return $this->hasMany(\App\Models\User::class, 'company_id', 'id')->role('staff');
    }

    public function users(): HasMany
    {
        return $this->hasMany(\App\Models\User::class, 'company_id', 'id');
    }
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function activeSubscription(): HasOne
    {
        return $this->hasOne(Subscription_Info::class, 'company_id')->where('purchase_date', '<=', now())->where('expire_date', '>=', now())->where('status', '!=', 3)->latest();
    }

    public function pendingSubscription(): HasOne
    {
        return $this->hasOne(Subscription_Info::class, 'company_id')->where('purchase_date', '<=', now())->where('expire_date', '>=', now())->where('status', 0)->latest();
    }

    public function socialMediaTokens(): HasMany
    {
        return $this->hasMany(SocialMediaToken::class, 'company_id', 'id');
    }

    public function companyActiveSubscription()
    {
        return $this->hasOne(Subscription_Info::class, 'company_id')->where('status', 1);
    }

    public function getQueuePriority()
    {
        if ($this->is_enterprise) {
            return 'high_priority';
        }
        if ($this->is_premium) {
            return 'medium_priority';
        }
        return 'low_priority';
    }

    public function getRateLimit()
    {
        if ($this->is_enterprise) {
            return 500;
        } // Messages per minute
        if ($this->is_premium) {
            return 200;
        }
        return 50; // Default for regular companies
    }
}
