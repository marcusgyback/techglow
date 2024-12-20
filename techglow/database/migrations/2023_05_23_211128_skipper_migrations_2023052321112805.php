<?php
/* 
 * Migrations generated by: Skipper (http://www.skipper18.com)
 * Migration id: e58bba71-2d81-4366-bbaa-bb45fd541327
 * Migration local datetime: 2023-05-23 21:11:28.057361
 * Migration UTC datetime: 2023-05-23 19:11:28.057361
 */ 

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SkipperMigrations2023052321112805 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->integer('kem_tax_percentage')->nullable(true)->default(100)->after('kem_tax');
        });
        Schema::table('products', function (Blueprint $table) {
            $table->integer('target_page')->nullable(true)->default(0)->after('published');
        });
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('target_page');
        });
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('kem_tax_percentage');
        });
    }
}
