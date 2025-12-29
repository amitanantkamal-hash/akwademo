<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('files', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('ids')->default(null);
            $table->tinyInteger('is_folder')->default(null);
            $table->string('name')->default(null);
            $table->string('file')->default(null);
            $table->string('type')->default(null);
            $table->string('extension')->default(null);
            $table->string('detect')->default(null);
            $table->integer('size')->default(null);
            $table->string('is_image')->default(null);
            $table->string('width')->default(null);
            $table->string('height')->default(null);
            $table->longText('note')->default(null);
            $table->unsignedBigInteger('company_id')->nullable();
            $table->foreign('company_id')->references('id')->on('companies');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('files');
    }
}
