<?php
/* 
 * Migrations generated by: Skipper (http://www.skipper18.com)
 * Migration id: 80a7c2d3-d8cb-4895-b568-3464bf8d096b
 * Migration local datetime: 2023-06-24 17:14:42.963640
 * Migration UTC datetime: 2023-06-24 15:14:42.963640
 */ 

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SkipperMigrations2023062417144296 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('brands', function (Blueprint $table) {
            $table->string('slug', 255)->nullable(true)->after('name');
        });
        Schema::table('menu', function (Blueprint $table) {
            $table->json('filters')->nullable(true)->after('slug');
        });
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('menu', function (Blueprint $table) {
            $table->dropColumn('filters');
        });
        Schema::table('brands', function (Blueprint $table) {
            $table->dropColumn('slug');
        });
    }
}