<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('companies', function (Blueprint $table) {
            $table->boolean('is_enterprise')->default(false);
            $table->boolean('is_premium')->default(false);

            // Optional: Add index for faster lookups
            $table->index('is_enterprise');
            $table->index('is_premium');
        });
    }

    public function down()
    {
        Schema::table('companies', function (Blueprint $table) {
            $table->dropColumn(['is_enterprise', 'is_premium']);
        });
    }
};
