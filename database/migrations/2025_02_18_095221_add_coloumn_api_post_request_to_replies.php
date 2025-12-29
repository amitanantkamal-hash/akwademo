<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('replies', function (Blueprint $table) {
            $table->string('header_type')->nullable()->after('name');
            $table->text('headerURL')->nullable()->after('header_type');
            $table->bigInteger('api_always_next_id')->nullable()->after('next_reply_id');
            $table->tinyInteger('isAPI')->nullable()->after('api_always_next_id');
            $table->string('api_res_save_type', 255)->nullable()->after('isAPI');
            $table->string('api_response_type', 255)->nullable()->after('api_res_save_type');
            $table->text('api_url')->nullable()->after('api_response_type');
            $table->enum('request_type', ['GET', 'POST', 'PUT', 'DELETE'])->nullable()->after('api_url');
            $table->text('post_data')->nullable()->after('request_type');
            $table->bigInteger('api_failure')->nullable()->after('post_data');
            $table->text('api_auth_token')->nullable()->after('api_failure');
            $table->string('list_menu_title', 255)->nullable()->after('api_auth_token');
            $table->string('list_ref_id', 255)->nullable()->after('list_menu_title');
            $table->string('list_ref_value', 255)->nullable()->after('list_ref_id');
            $table->string('list_ref_description', 255)->nullable()->after('list_ref_value');
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('replies', function (Blueprint $table) {
            //
        });
    }
};
