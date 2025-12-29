<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCtwaAdsClickLeads extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('ctwa_ads_click_leads', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('company_id');
            $table->unsignedBigInteger('contact_id')->nullable();
            $table->string('source_url')->nullable();
            $table->string('source_id')->nullable();
            $table->string('source_type')->nullable();
            $table->string('wa_id');
            $table->timestamps();

            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
            $table->foreign('contact_id')->references('id')->on('contacts')->onDelete('set null');

            $table->index('wa_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ctwa_ads_click_leads');
    }
}
