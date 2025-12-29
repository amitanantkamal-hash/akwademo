<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddMultipleColumnInContacts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('contacts', function (Blueprint $table) {

            $table->text('api_validate_response')->comment('ValidateData ##validata.{{id}}## API call data')->nullable(true);
            $table->text('keep_interactive_data')->comment('SessionData ##sessdata.{{id}}## Interactive Data from API')->nullable(true);
            $table->string('keep_interactive_id', 255)->comment('SessionData Selected Interactive ID from List')->nullable(true);
            $table->integer('keep_selected_listrow')->comment('SessionData Selected Interactive Row ID from List')->nullable(true);

            $table->text('keep_current_api_data')->comment('CurrentData ##currdata.{{id}}## Interactive Data from API')->nullable(true);
            $table->string('keep_current_interactive_id', 255)->comment('CurrentData Selected Interactive ID from List')->nullable(true);
            $table->integer('keep_current_selected_listrow')->comment('CurrentData Selected Interactive Row ID from List')->nullable(true);

            $table->text('keep_api_data')->comment('APIData ##apidata.{{id}}## API call data')->nullable(true);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('contacts', function (Blueprint $table) {

        });
    }
}
