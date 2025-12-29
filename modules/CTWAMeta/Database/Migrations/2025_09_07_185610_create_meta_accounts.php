<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMetaAccounts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('meta_accounts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('account_id');
            $table->string('name');
            $table->enum('type', ['ctwa', 'non_ctwa']);
            $table->tinyInteger('status')->default(0);
            $table->string('amount_spent');
            $table->string('business_id');
            $table->text('access_token');
            $table->unsignedBigInteger('company_id');
            $table->unsignedBigInteger('fb_connection_id');
            $table->timestamps();

            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
            $table->foreign('fb_connection_id')->references('id')->on('facebook_app_connections')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('meta_accounts');
    }
}
