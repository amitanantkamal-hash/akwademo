<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateRepliesTableWithHeaderInfo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('replies', function (Blueprint $table) {
            $table->dropColumn(['button1', 'button1_id', 'button2','button2_id','button3','button3_id','button_name','button_url']);
            $table->tinyInteger('is_bot_active')->nullable(false)->default(1)->comment("Flag to represent if the bot is active or not");
          //  $table->string('header_type')->default(null)->comment("1- Text, 2- Image, 3- Video, 4- File, 5- Location, 6-Contact");
            $table->string('interactive_template_group');
            $table->string('media');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        
    }
}
