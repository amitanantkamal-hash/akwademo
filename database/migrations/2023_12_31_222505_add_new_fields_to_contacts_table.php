<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('contacts', function (Blueprint $table) {
            $table->string('title')->nullable();
            $table->string('position')->nullable();
            $table->string('website')->nullable();
            $table->string('city')->nullable();
            $table->text('address')->nullable();
            $table->string('gender')->nullable();
            $table->integer('rating')->default(0);
            $table->text('notes')->nullable();
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
            $table->dropColumn([
                'email',
                'title',
                'position',
                'website',
                'city',
                'address',
                'gender',
                'rating',
                'notes'
            ]);
        });
    }
};
