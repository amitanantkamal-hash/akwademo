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
            $table->integer('contact_limit')->default(0)->nullable(false)->change();
            $table->integer('campaigns_limit')->default(0)->nullable(false)->change();
            $table->integer('conversation_limit')->default(0)->nullable(false)->change();
            $table->integer('team_limit')->default(0)->nullable(false)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('plan', function (Blueprint $table) {
            $table->string('contact_limit')->change();
            $table->string('campaigns_limit')->change();
            $table->string('conversation_limit')->change();
            $table->string('team_limit')->change();
        });
    }
};
