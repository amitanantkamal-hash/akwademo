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
            $table->string('otp')->nullable()->after('trial_ends_at');
            $table->tinyInteger('otp_resend')->default(0)->after('otp');
            $table->tinyInteger('otp_change_number')->default(0)->after('otp_resend');
            $table->tinyInteger('is_optin')->default(1)->after('otp_change_number');
            $table->tinyInteger('is_otp_verified')->default(0)->after('is_optin');
            $table->timestamp('otp_sent_at')->nullable()->after('is_otp_verified');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
};
