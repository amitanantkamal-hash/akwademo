<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCatalogColumnWaTemplatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('wa_templates', function (Blueprint $table) {
            $table->integer('type')->default(0)->comment('1 => catalog, 2 => dob, 3 => doa, 4 => assessment contact')->after('company_id'); // specify after which column

            $table->string('day_type', 11)->nullable()->collation('utf8mb4_unicode_520_ci')->after('type');

            $table->string('product_id', 255)->nullable()->after('day_type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('wa_templates', function (Blueprint $table) {
            $table->dropColumn(['type', 'day_type', 'product_id']);
        });
    }
}
