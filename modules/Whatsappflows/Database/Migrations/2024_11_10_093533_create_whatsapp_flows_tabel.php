<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWhatsappFlowsTabel extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('whatsapp_flows', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('company_id')->nullable(false);
            $table->foreign('company_id')->references('id')->on('companies');
            $table->string('flow_name',191)->nullable(false);
            $table->string('whatsapp_flow_category',191)->nullable(false);
            $table->integer('whatsapp_bot_reply')->nullable(true);
            $table->string('screen_id',191)->nullable(true);
            $table->string('form_title',191)->nullable(false);
            $table->string('unique_flow_id',191)->nullable();
            $table->text('form_data')->nullable(true);
            $table->text('flow_data')->nullable(true);
            $table->string('unique_file_name', 255)->nullable(true);
            $table->string('can_send_message', 191)->nullable(false);
            $table->bigInteger('entity_id')->nullable(false);
            $table->text('preview_url')->nullable(false);
            $table->string('status', 55)->nullable(false);
            $table->text('download_url')->nullable(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('whatsapp_flows');
    }
}
