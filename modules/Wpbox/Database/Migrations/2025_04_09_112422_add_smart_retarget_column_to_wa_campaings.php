<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSmartRetargetColumnToWaCampaings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('wa_campaings', function (Blueprint $table) {
            $table->integer('smart_retarget_id')->nullable();
            $table->string('smart_retarget_type')->nullable()->after('smart_retarget_id');
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
            $table->dropColumn(['smart_retarget_id', 'smart_retarget_type']);
        });
    }
}
