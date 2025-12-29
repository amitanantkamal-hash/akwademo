<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAbandonedCartsSettingsTable extends Migration
{
    public function up()
    {
        Schema::create('abandoned_cart_settings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('company_id');
            $table->boolean('enabled')->default(false);
            $table->json('campaign_ids')->nullable(); // Array of campaign IDs for each interval
            $table->json('schedule_days'); // Store days (0 for same day, 1 for next day, etc.)
            $table->json('schedule_times'); // Store times in 24h format (e.g., "14:30")
            $table->integer('max_reminders')->default(3);
            $table->timestamps();

            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
            $table->unique(['company_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('abandoned_cart_settings');
    }
}
