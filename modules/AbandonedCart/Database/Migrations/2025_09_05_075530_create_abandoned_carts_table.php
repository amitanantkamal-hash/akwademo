<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAbandonedCartsTable extends Migration
{
    public function up()
    {
        Schema::create('abandoned_carts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('company_id');
            $table->enum('platform', ['shopify', 'woocommerce']);
            $table->string('cart_id');
            $table->string('customer_name');
            $table->string('customer_phone');
            $table->text('cart_contents');
            $table->decimal('cart_total', 10, 2);
            $table->string('status')->default('active'); // active, recovered, expired
            $table->timestamp('abandoned_at');
            $table->timestamp('recovered_at')->nullable();
            $table->timestamps();

            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
            $table->index(['company_id', 'platform', 'status']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('abandoned_carts');
    }
}
