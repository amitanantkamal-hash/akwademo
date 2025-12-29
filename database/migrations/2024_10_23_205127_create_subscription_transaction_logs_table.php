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
        if (!Schema::hasTable('subscription_transaction_logs')) {
            Schema::create('subscription_transaction_logs', function (Blueprint $table) {
                $table->id();
                $table->longText('description')->nullable();
                $table->unsignedBigInteger('company_id')->nullable();
                // $table->foreign('user_id')->references('id')->on('clients')->onDelete('set null');
                $table->unsignedBigInteger('created_by')->nullable();
                // $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');
                $table->unsignedBigInteger('updated_by')->nullable();
                // $table->foreign('updated_by')->references('id')->on('users')->onDelete('set null');
                $table->timestamps();
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
        Schema::dropIfExists('subscription_transaction_logs');
    }
};
