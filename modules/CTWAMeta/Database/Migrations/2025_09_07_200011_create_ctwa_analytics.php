<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCtwaAnalytics extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('ctwa_analytics', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('meta_account_id');
            $table->unsignedBigInteger('company_id');
            $table->date('date');
            $table->json('metrics')->nullable();
            $table->timestamps();

            $table->unique(['meta_account_id', 'date']);
            $table->foreign('meta_account_id')->references('id')->on('meta_accounts')->onDelete('cascade');
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ctwa_analytics');
    }
}
