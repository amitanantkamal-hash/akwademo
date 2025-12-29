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
        Schema::table('subscriptions_info', function (Blueprint $table) {
            $table->dateTime('purchase_date')->nullable()->after('status');
            $table->double('price')->default(0)->after('expire_date');
            $table->string('package_type')->nullable()->after('price');
            $table->unsignedBigInteger('contact_limit')->default(0)->after('package_type');
            $table->unsignedBigInteger('campaign_limit')->default(0)->after('contact_limit');
            $table->unsignedBigInteger('message_limit')->default(0)->after('campaign_limit');
            $table->unsignedBigInteger('team_limit')->default(0)->after('message_limit');
            $table->string('trx_id')->after('team_limit');
            $table->string('payment_method')->after('trx_id');
            $table->text('payment_details')->after('payment_method');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('subscriptions_info', function (Blueprint $table) {
            //
        });
    }
};
