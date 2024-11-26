<?php

namespace App\Helpers;

class KemTaxCalculation
{

    static array $taxes = [
        "2023" => [
            "roof" => 489,
            "appliances" => 11,
            "others" => 160,
            "none" => 0,
        ]
    ];

    public static function Calculate(string $tax_type, float $weight, int|null $year = null)
    {
        if(is_null($year))
        {
            $year = date("Y");
        }
        $tax = self::$taxes[$year];
        $tax_rate = $tax[$tax_type];
        $roof_price = $tax["roof"];
        $kem_tax = $weight * $tax_rate;
        if($kem_tax > $roof_price)
        {
            return $roof_price;
        }
        return $kem_tax;
    }
}
