<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('subscriptions_info', function (Blueprint $table) {
            $table->tinyInteger('is_trial')->default(0)->nullable(false)->after('trial_expire_date');
            $table->double('amount_paid')->default(0)->nullable(false)->after('is_trial');
            $table->text('stripe_invoice_details')->nullable(true)->after('amount_paid');
            $table->tinyInteger('is_offline')->default(0)->nullable(false)->after('stripe_invoice_details');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('subscriptions_info', function (Blueprint $table) {
            //
        });
    }
};
