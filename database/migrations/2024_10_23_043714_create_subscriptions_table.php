<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /** 
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subscriptions_info', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('company_id')->nullable();
            $table->foreign('company_id')->references('company_id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedBigInteger('plan_id')->nullable();
            $table->string('is_recurring');
            $table->integer('message_remaining')->default(0)->nullable();
            $table->integer('campaign_remaining')->default(0)->nullable();
            $table->boolean('status')->default(0)->comment('0:pending,1:active,2:rejected,3:inactive');
            $table->date('expire_date')->nullable();
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
        Schema::dropIfExists('subscriptions_info');
    }
};
