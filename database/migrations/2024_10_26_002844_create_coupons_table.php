<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCouponsTable extends Migration
{
    public function up()
    {
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->enum('discount_type', ['percentage', 'fixed']);
            $table->integer('discount_value');
            $table->integer('usage_limit')->nullable();
            $table->integer('usage_count')->default(0)->nullable();
            $table->date('expiration_date')->nullable();
            $table->string('stripe_coupon_id')->nullable();
            $table->string('applicable_plan_ids')->nullable(); // JSON field to store plan IDs
            $table->timestamps();
        });      
    }

    public function down()
    {
        Schema::dropIfExists('coupons');
    }
}
