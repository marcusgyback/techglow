<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Partner\PartnerSubscriber;

class PartnerSubscriberSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        PartnerSubscriber::factory(300)->create();
    }
}
