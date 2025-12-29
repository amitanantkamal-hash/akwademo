<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddReplyTrackingToContactsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('contacts', function (Blueprint $table) {
            $table->boolean('is_replied')->default(false);
            $table->timestamp('replied_at')->nullable();
            $table->timestamp('template_sent_at')->nullable();
            $table->bigInteger('last_campaign_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('contacts', function (Blueprint $table) {
            $table->dropColumn(['is_replied', 'replied_at', 'template_sent_at','last_campaign_id']);
        });
    }
}
