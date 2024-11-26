<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product\Menu;
use App\Models\Product\Product;
use App\Models\Product\Brand;
use App\Helpers\ProductQueryFilters;


class CategoriController extends Controller
{
    public function show(Request $request, string $slug)
    {
        $req_menu = Menu::where('slug', $slug)->first();
        if(is_null($req_menu))
        {
            abort(404);
        }
        $productsQ = Product::where('menu_id', '=' , $req_menu->id)
            ->where('published', true);
        ProductQueryFilters::Apply($request,$productsQ, $req_menu);
        $filters = ProductQueryFilters::getFilters($req_menu);
        $filters['price']['max'] = $productsQ->max('selling_price') / 100;
        $filters['price']['min'] = $productsQ->min('selling_price') / 100;
        $brand_id = $productsQ->distinct()->get(['brand_id']);
        $filters['brand'] = Brand::find($brand_id);
        $products = $productsQ->paginate(ProductQueryFilters::paginate($request));
        return view('frontend/webshop/categoripage', compact('req_menu','products', 'filters'));
    }
}
