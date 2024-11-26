<?php

namespace App\Helpers;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use App\Models\Product\Menu;

class ProductQueryFilters
{

    static public function Apply(Request &$request, Builder &$query, Menu &$menu)
    {
        self::queryBrandFilter($query, $request);
        self::queryPriceFilter($query, $request);
        self::filter($request, $query, $menu);
        self::queryOrder($query, $request);
    }

    static private function queryBrandFilter(Builder &$query, Request &$request):void
    {
        $brand = $request->input("brand", null);
        if(is_numeric($brand))
        {
            $query->where('brand_id', '=', $brand);
        }elseif (!is_null($brand)){
            $brands = explode(',',$brand);
            if(is_array($brands) && count($brands))
            {
                $query->whereIn('brand_id', $brands);
            }
        }
    }

    static private function queryPriceFilter(Builder &$query, Request &$request):void
    {
        $price_min = $request->input("price_min", null);
        $price_max = $request->input("price_max", null);
        if(is_numeric($price_min) && is_numeric($price_max))
        {
            $query->whereBetween('selling_price', [($price_min * 100), ($price_max * 100)]);
        }
        elseif(is_numeric($price_min) && !is_numeric($price_max))
        {
            $query->where('selling_price', '>=', ($price_min * 100));
        }
        elseif(!is_numeric($price_min) && is_numeric($price_max))
        {
            $query->where('selling_price', '>=', ($price_min * 100));
        }
    }

    static private function queryOrder(Builder &$query, Request &$request): void
    {
        $query->orderBy('target_page', 'DESC');
        $query->orderBy('id', 'DESC');
    }

    static public function paginate(Request &$request): int
    {
        $paginate = $request->input("limit", 16);
        if(!is_numeric($paginate))
        {
            $paginate = 16;
        }elseif (($paginate > 100) || ($paginate <= 0)){
            $paginate = 16;
        }
        return $paginate;
    }

    static private function filter(Request &$request, Builder &$query, Menu &$menu): void
    {
        if(is_null($menu->filters))
        {
            return;
        }

        dd($menu->filters);
    }

    static public function getFilters(Menu &$menu): array
    {



        //$menu->filters;
        return [];
    }
}
