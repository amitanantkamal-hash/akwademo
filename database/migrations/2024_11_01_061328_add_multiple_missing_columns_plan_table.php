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
            $table->integer('max_chatwidget')->default(0)->after('team_limit');
            $table->integer('max_flow_builder')->default(0)->after('max_chatwidget');
            $table->integer('max_bot_reply')->default(0)->after('max_flow_builder');
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
