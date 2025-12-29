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
            // Add is_active field if it doesn't exist
            if (!Schema::hasColumn('users', 'is_active')) {
                $table->boolean('is_active')->default(true)->after('email_verified_at');
            }

            // Add last_logged_in_on field
            if (!Schema::hasColumn('users', 'last_logged_in_on')) {
                $table->timestamp('last_logged_in_on')->nullable()->after('is_active');
            }

            // Add deactivated_at field for tracking deactivation
            if (!Schema::hasColumn('users', 'deactivated_at')) {
                $table->timestamp('deactivated_at')->nullable()->after('last_logged_in_on');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Only remove columns if they exist
            if (Schema::hasColumn('users', 'is_active')) {
                $table->dropColumn('is_active');
            }
            if (Schema::hasColumn('users', 'last_logged_in_on')) {
                $table->dropColumn('last_logged_in_on');
            }
            if (Schema::hasColumn('users', 'deactivated_at')) {
                $table->dropColumn('deactivated_at');
            }
        });
    }
};
