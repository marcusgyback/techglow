<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class SupplierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $suppliers = [
            [
                'supplier_number' => "3",
                "slug" => "bigbuy",
                "active" => true,
                "name" => "BigBuy Europe",
                "api" => true,
                "flow_class" => "bigbuy::class",
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ],
            [
                'supplier_number' => "2",
                "slug" => "despec",
                "active" => true,
                "name" => "Despec Sweden AB",
                "api" => true,
                "flow_class" => "despec::class",
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ],
            [
                "slug" => "itegra",
                'active' => false,
                'name' => "Itegra (Komplett Distribution Sweden AB)",
                'supplier_number' => "1",
                'api' => true,
                'flow_class' => "itegra::class",
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ],
        ];

        DB::table('suppliers')->insert($suppliers);

    }
}



