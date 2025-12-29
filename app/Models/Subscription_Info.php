<?php
namespace App\Models;

use App\Events\SubscriptionInfoCreatedEvent;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Subscription_Info extends Model
{
    use HasFactory;
    protected $table = 'subscriptions_info';

    protected $fillable = [
        'company_id',
        'plan_id',
        'is_recurring',
        'status',
        'purchase_date',
        'expire_date',
        'trial_expire_date',
        'price',
        'is_trial',
        'amount_paid',
        'stripe_invoice_details',
        'is_offline',
        'package_type',
        'contact_limit',
        'campaign_limit',
        'campaign_remaining',
        'conversation_limit',
        'conversation_remaining',
        'team_limit',
        'max_chatwidget',
        'max_flow_builder',
        'max_bot_reply',
        'trx_id',
        'payment_method',
        'payment_details',
        'canceled_at',
        'billing_name',
        'billing_email',
        'billing_address',
        'billing_city',
        'billing_state',
        'billing_zip_code',
        'billing_country',
        'billing_phone',

    ];

    protected $dispatchesEvents = [
        'created' => SubscriptionInfoCreatedEvent::class,
    ];

    protected $casts    = [
        'payment_details' => 'array',
    ];

    public function plan(): BelongsTo
    {
        return $this->belongsTo(Plans::class);
    }

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class, 'company_id');
    }
}
