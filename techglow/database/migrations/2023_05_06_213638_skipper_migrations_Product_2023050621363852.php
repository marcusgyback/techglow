<?php
/* 
 * Migrations generated by: Skipper (http://www.skipper18.com)
 * Migration id: 5ea04e77-099c-46e9-aaac-e7d27e430ffa
 * Migration local datetime: 2023-05-06 21:36:38.521993
 * Migration UTC datetime: 2023-05-06 19:36:38.521993
 */ 

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SkipperMigrationsProduct2023050621363852 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('purchase_price', function (Blueprint $table) {
            $table->integer('stock')->unsigned()->after('article_number');
        });
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('purchase_price', function (Blueprint $table) {
            $table->dropColumn('stock');
        });
    }
}