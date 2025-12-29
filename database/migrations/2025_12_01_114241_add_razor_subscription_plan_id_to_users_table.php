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
        Schema::table('users', function (Blueprint $table) {
            $table->timestamp('razor_subscription_start_at')->nullable()->after('free_plan_used');

            $table->timestamp('razor_subscription_next_renewal_at')->nullable()->after('razor_subscription_start_at');

            $table->string('razor_subscription_plan_id')->nullable()->after('razor_subscription_next_renewal_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'razor_subscription_start_at',
                'razor_subscription_next_renewal_at',
                'razor_subscription_plan_id',
            ]);
        });
    }
};
