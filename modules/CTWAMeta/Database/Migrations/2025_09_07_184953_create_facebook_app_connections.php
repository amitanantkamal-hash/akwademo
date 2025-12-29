<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFacebookAppConnections extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('facebook_app_connections', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('company_id');
            $table->string('fb_user_id');
            $table->text('access_token');
            $table->text('long_lived_token')->nullable();
            $table->timestamp('token_expires_at')->nullable();
            $table->string('webhook_secret', 64)->nullable();
            $table->string('webhook_url', 255)->nullable();
            $table->json('ad_accounts')->nullable();
            $table->timestamps();

            $table->unique(['company_id', 'fb_user_id']);
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('facebook_app_connections');
    }
}
