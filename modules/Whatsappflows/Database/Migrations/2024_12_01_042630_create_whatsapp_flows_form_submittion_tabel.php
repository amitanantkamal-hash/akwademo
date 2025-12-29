<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWhatsappFlowsFormSubmittionTabel extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('whatsapp_flows_form_submittion', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('company_id')->nullable(false);
            $table->foreign('company_id')->references('id')->on('companies');
            $table->unsignedBigInteger('flow_id')->nullable(false);
            $table->text('form_data')->nullable(true);
            $table->string('phone_number_id',191)->nullable(false);
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
        Schema::dropIfExists('whatsapp_flows_form_submittion');
    }
}
