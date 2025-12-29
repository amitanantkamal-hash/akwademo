<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddMultipleColumnInMessages extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('messages', function (Blueprint $table) {
            $table->string('file_name')->comment('PDF File name for WhatsApp ref')->nullable(true)->after('header_document');
            $table->tinyInteger('response_type')->comment('2 for others 1 for List')->default(2)->after('is_note');
            $table->text('list_section_data')->comment('List section data')->nullable(true)->after('response_type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('messages', function (Blueprint $table) {

        });
    }
}
