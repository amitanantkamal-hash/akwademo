<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMetaLeads extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('meta_leads', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('company_id');
            $table->unsignedBigInteger('meta_page_id');
            $table->unsignedBigInteger('business_id')->nullable();
            $table->unsignedBigInteger('meta_account_id')->nullable();

            $table->string('ad_id')->nullable();
            $table->string('ad_name')->nullable();
            $table->string('campaign_id')->nullable();
            $table->string('campaign_name')->nullable();
            $table->string('platform')->nullable();
            $table->string('form_id')->nullable();
            $table->string('leadgen_id')->unique();
            $table->string('adgroup_id')->nullable();
            $table->string('page_id')->nullable();
            $table->string('name')->nullable();

            $table->json('field_data');
            $table->timestamp('received_at')->nullable();
            $table->boolean('processed')->default(false);
            $table->timestamp('processed_at')->nullable();

            $table->timestamps();

            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
            $table->foreign('meta_page_id')->references('id')->on('meta_pages')->onDelete('cascade');
            $table->foreign('business_id')->references('id')->on('meta_business_accounts')->onDelete('cascade');
            $table->foreign('meta_account_id')->references('id')->on('meta_accounts')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('meta_leads');
    }
}
