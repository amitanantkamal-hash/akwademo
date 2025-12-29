<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMetaPages extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('meta_pages', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('page_id')->unique();
            $table->unsignedBigInteger('company_id');
            $table->unsignedBigInteger('fb_connection_id');
            $table->string('business_id')->nullable();
            $table->string('name');
            $table->string('category')->nullable();
            $table->text('access_token');
            $table->text('picture_url')->nullable();
            $table->json('tasks')->nullable();
            $table->json('page_permissions')->nullable();
            $table->timestamps();

            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
            $table->foreign('fb_connection_id')->references('id')->on('facebook_app_connections')->onDelete('cascade');
            // Note: this references business_id in meta_business_accounts (string)
            $table->foreign('business_id')->references('business_id')->on('meta_business_accounts')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('meta_pages');
    }
}
