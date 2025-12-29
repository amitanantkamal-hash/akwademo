<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddInputMessageColumnsInContactsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('contacts', function (Blueprint $table) {
            $table->tinyInteger('isInputDataReply')->default(0)->after('tmp_group_id');
            $table->integer('isInputMessageFor')->nullable(true)->after('isInputDataReply');
            $table->string('inputDataTemp', 191)->nullable(true)->after('isInputMessageFor');
            $table->text('inputDataKeep')->nullable(true)->after('inputDataTemp');
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
