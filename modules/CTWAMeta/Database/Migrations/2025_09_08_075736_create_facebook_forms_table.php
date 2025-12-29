<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFacebookFormsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('facebook_forms', function (Blueprint $table) {
            $table->id();

            // Company relation
            $table->unsignedBigInteger('company_id');
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
            $table->bigInteger('meta_page_id');
            $table->string('form_id')->unique();
            $table->string('name')->nullable();
            $table->timestamp('created_time')->nullable();
            $table->json('questions')->nullable(); // store form questions
            $table->string('webhook_url')->nullable(); // user-set webhook

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('facebook_forms');
    }
}
