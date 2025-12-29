<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSmartclickTriggersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('smart_click_triggers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('monitor_id')->constrained('smart_click_monitors')->onDelete('cascade');
            $table->string('keyword');
            $table->timestamps();

            $table->unique(['monitor_id', 'keyword']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('smart_click_triggers');
    }
}
