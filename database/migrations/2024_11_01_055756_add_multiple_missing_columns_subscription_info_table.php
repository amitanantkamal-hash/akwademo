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
            $table->unsignedBigInteger('conversation_limit')->default(0)->after('message_limit');
            $table->unsignedBigInteger('conversation_remaining')->default(0)->after('conversation_limit');
            $table->unsignedBigInteger('max_chatwidget')->default(0)->after('conversation_remaining');
            $table->unsignedBigInteger('max_flow_builder')->default(0)->after('max_chatwidget');
            $table->unsignedBigInteger('max_bot_reply')->default(0)->after('max_flow_builder');
            $table->string('billing_name')->nullable()->after('max_bot_reply');
            $table->string('billing_email')->nullable()->after('billing_name');
            $table->string('billing_address')->nullable()->after('billing_email');
            $table->string('billing_city')->nullable()->after('billing_address');
            $table->string('billing_state')->nullable()->after('billing_city');
            $table->string('billing_zip_code')->nullable()->after('billing_state');
            $table->string('billing_country')->nullable()->after('billing_zip_code');
            $table->string('billing_phone')->nullable()->after('billing_country');

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
