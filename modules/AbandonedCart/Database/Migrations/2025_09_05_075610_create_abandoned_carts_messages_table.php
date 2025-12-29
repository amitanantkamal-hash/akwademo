<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAbandonedCartsMessagesTable extends Migration
{
    public function up()
    {
        Schema::create('abandoned_cart_messages', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('abandoned_cart_id');
            $table->unsignedBigInteger('campaign_id');
            $table->json('payload');
            $table->timestamp('scheduled_at');
            $table->timestamp('sent_at')->nullable();
            $table->string('status')->default('scheduled'); // scheduled, sent, failed, cancelled
            $table->text('response')->nullable();
            $table->timestamps();

            $table->foreign('abandoned_cart_id')->references('id')->on('abandoned_carts')->onDelete('cascade');
            $table->index(['scheduled_at', 'status']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('abandoned_cart_messages');
    }
}
