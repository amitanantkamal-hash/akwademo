<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAutoretargetTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Create autoretarget campaigns table
        Schema::create('autoretarget_campaigns', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->onDelete('cascade'); // belongs to company
            $table->string('name');
            $table->text('description')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // Create autoretarget messages table
        Schema::create('autoretarget_messages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->onDelete('cascade'); // belongs to company
            $table->foreignId('autoretarget_campaign_id')->constrained()->onDelete('cascade');
            $table->foreignId('campaign_id')->constrained('wa_campaings')->onDelete('cascade');
            $table->integer('delay_days');
            $table->time('send_time');
            $table->integer('order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // Add autoretarget toggle to campaigns table
        Schema::table('wa_campaings', function (Blueprint $table) {
            $table->boolean('autoretarget_enabled')->default(false);
            $table->foreignId('autoretarget_campaign_id')
                  ->nullable()
                  ->constrained('autoretarget_campaigns')
                  ->onDelete('set null');
        });

        // Create autoretarget logs table
        Schema::create('autoretarget_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->onDelete('cascade'); // belongs to company
            $table->foreignId('autoretarget_campaign_id')->constrained()->onDelete('cascade');
            $table->foreignId('campaign_id')->constrained('wa_campaings')->onDelete('cascade');
            $table->foreignId('contact_id')->constrained()->onDelete('cascade');
            $table->foreignId('autoretarget_message_id')->constrained()->onDelete('cascade');
            $table->timestamp('sent_at')->nullable();
            $table->string('status')->default('pending'); // pending, sent, failed
            $table->text('response')->nullable();
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
        Schema::table('wa_campaings', function (Blueprint $table) {
            $table->dropColumn('autoretarget_enabled');
            $table->dropForeign(['autoretarget_campaign_id']);
            $table->dropColumn('autoretarget_campaign_id');
        });

        Schema::dropIfExists('autoretarget_logs');
        Schema::dropIfExists('autoretarget_messages');
        Schema::dropIfExists('autoretarget_campaigns');
    }
}
