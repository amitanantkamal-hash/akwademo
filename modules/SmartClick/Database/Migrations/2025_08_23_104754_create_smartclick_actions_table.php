<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSmartclickActionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('smart_click_actions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('monitor_id')->constrained('smart_click_monitors')->onDelete('cascade');
            $table->enum('action_type', ['add_tags', 'remove_tags', 'add_groups', 'remove_groups', 'custom_field', 'whatsapp']);
            $table->text('action_value');
            $table->integer('delay_minutes')->default(0);
            $table->integer('order')->default(0);
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
        Schema::dropIfExists('smart_click_actions');
    }
}
