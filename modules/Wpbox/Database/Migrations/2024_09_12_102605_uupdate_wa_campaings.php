<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UupdateWaCampaings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('wa_campaings', function (Blueprint $table) {
            $table->boolean(column: 'is_reminder')->default(false)->comment("Flag to represent if the campaign is for Reminder");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('wa_campaings', function (Blueprint $table) {
            $table->dropColumn(['is_reminder']);
        });
    }
}
