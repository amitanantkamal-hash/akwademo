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
        Schema::table('plan', function (Blueprint $table) {
            $table->string('billing_period')->nullable();
            $table->integer('contact_limit')->nullable();
            $table->integer('campaigns_limit')->nullable();
            $table->integer('conversation_limit')->nullable();
            $table->integer('team_limit')->nullable();
            $table->tinyInteger('status')->default(1)->comment('0 inactive, 1 active');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('plan', function (Blueprint $table) {
            //
        });
    }
};
