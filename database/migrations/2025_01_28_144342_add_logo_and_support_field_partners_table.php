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
        Schema::table('partners', function (Blueprint $table) {
            $table->string('logo')->nullable(true)->after('is_active');
            $table->string('support_whatsapp_number')->nullable(true)->after('logo');
            $table->string('support_email')->nullable(true)->after('support_whatsapp_number');
            $table->string('support_link')->nullable(true)->after('support_email');
            $table->string('support_chat_plugin')->nullable(true)->after('support_link');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
