<?php

namespace App\Helpers;

use App\Models\Product\PurchasePrice;
use App\Models\Product\Product;


class PriceCalculation
{
    public static function Calculate(Product $product, PurchasePrice $purchasePrice, Float $exchange_rate, Float $kem_tax): int
    {
        $margin_target =  1.0 + ($product->margin_target / 100);
        $price_sek = ceil(($exchange_rate * $purchasePrice->price_retail));
        $price_target = $price_sek * $margin_target;
        $price = $price_target + $kem_tax;
        $med_moms = $price * 1.25;
        $oren = (int) (ceil($med_moms) * 100);
        return $oren;
    }

    public static function CalculatePurchasePriceInkMoms(PurchasePrice $purchasePrice, Float $exchange_rate, Float $kem_tax): int
    {
        $price_sek = ($exchange_rate * $purchasePrice->price_retail);
        $price = $price_sek + $kem_tax;
        $med_moms = ($price * 1.01 ) * 1.25;
        $oren = (int) (ceil($med_moms) * 100);
        return $oren;
    }
}
