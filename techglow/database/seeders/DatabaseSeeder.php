<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();
        $this->call(UserSeeder::class);
        $this->call(RolesSeeder::class);

        $this->call(PartnerSeeder::class);
        $this->call(PartnerSubscriberSeeder::class);

        $this->call(PaymentProviderSeeder::class);
        $this->call(SupplierSeeder::class);

        $this->call(CategorieSeeder::class);
        $this->call(CategoriesSubscribeSeeder::class);
        $this->call(CategoriesPopulate::class);
        $this->call(MenuSeeder::class);

        $this->call(ExchangeRatesSeeder::class);
        $this->call(BrandSeeder::class);
        $this->call(BrandPopulate::class);
        $this->call(ProductBrandPolifillSeeder::class);
        $this->call(ProductInfoSeeder::class);
        $this->call(ShippingSeeder::class);

        $this->call(ProductsTaxonomiesSeeder::class);
        $this->call(ProductSeeder::class);

        $this->call(ImagesSeeder::class);
        $this->call(StockSeeder::class);

        $this->call(ProductsPopulate::class);
        $this->call(SellingPricePopulate::class);
        Model::reguard();
    }
}
