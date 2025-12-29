<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddInputMessageColumnsInRepliesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('replies', function (Blueprint $table) {
            $table->string('input_type', 191)->comment('TEXT/IMG/DATE')->nullable(true)->after('list_ref_description');
            $table->string('input_variable', 191)->nullable(true)->after('input_type');
            $table->tinyInteger('isNextInput')->default(0)->after('input_variable');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('replies', function (Blueprint $table) {

        });
    }
}
