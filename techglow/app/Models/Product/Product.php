<?php
namespace App\Models\Product;

use App\Models\Product\SellingPrice;
use Outl1ne\NovaMediaHub\Models\Media;

class Product extends \App\Models\Product\AbstractModels\AbstractProduct
{

    public function getImages()
    {
        if(is_null($this->image)) {
            return null;
        }
        return Media::whereIn('id', $this->image)->get();
    }

    public function getSellingPrice()
    {
        if(!is_null($this->selling_price))
        {
            return $this->selling_price;
        }

        $price_data = $this->getSellingPriceData();

        if(!is_null($price_data))
        {
            return $price_data["price"];
        }
        return false;
    }

    public function getSellingPriceData()
    {
        try {
            $price = $this->getSellingPriceRow()?->toArray();
        }catch (\Exception $e) {
            return false;
        }
        return $price;

    }
    public function getSellingPriceRow()
    {
        try {
            $price = SellingPrice::where('product_id', $this->id)->where('campaign', '=', 0)->where(function ($query) {
                $query->where(function ($query) {
                    $query->where('valid_from', '<=', \DB::raw('NOW()'))->
                    where('valid_to', '>', \DB::raw('NOW()'));
                })->orWhere(function ($query) {
                    $query->where('valid_from', '<=', \DB::raw('NOW()'))
                        ->WhereNull('valid_to');
                });
            })->orderByDesc('created_at')->get()->first();
        }catch (\Exception $e) {
            return false;
        }
        return $price;
    }
}
