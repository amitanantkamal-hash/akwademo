<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class FixAutoretargetForeignKeyColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Check if the wrong column exists and rename it
        if (Schema::hasColumn('autoretarget_messages', 'auto_retarget_campaign_id')) {
            Schema::table('autoretarget_messages', function (Blueprint $table) {
                $table->renameColumn('auto_retarget_campaign_id', 'autoretarget_campaign_id');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Reverse the changes
        if (Schema::hasColumn('autoretarget_messages', 'autoretarget_campaign_id')) {
            Schema::table('autoretarget_messages', function (Blueprint $table) {
                $table->renameColumn('autoretarget_campaign_id', 'auto_retarget_campaign_id');
            });
        }
    }
}
