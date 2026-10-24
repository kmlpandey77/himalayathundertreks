<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterPackagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('packages', function (Blueprint $table) {
            $table->float('deluxe_price', 10, 2)->nullable()->after('price');
            $table->text('deluxe_price_include')->nullable()->after('include');
            $table->text('deluxe_price_exclude')->nullable()->after('exclude');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('packages', function (Blueprint $table) {
            $table->dropColumn('deluxe_price');
            $table->dropColumn('deluxe_price_include');
            $table->dropColumn('deluxe_price_exclude');
        });
    }
}
