<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMetaBusinessAccounts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('meta_business_accounts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('business_id')->unique();
            $table->string('name');
            $table->string('vertical')->nullable();
            $table->string('primary_page_id')->nullable();
            $table->string('business_profile')->nullable();
            $table->text('picture_url')->nullable();
            $table->text('link')->nullable();
            $table->json('raw_data')->nullable();
            $table->unsignedBigInteger('company_id');
            $table->unsignedBigInteger('fb_connection_id');
            $table->timestamps();

            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
            $table->foreign('fb_connection_id')->references('id')->on('facebook_app_connections')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('meta_business_accounts');
    }
}
