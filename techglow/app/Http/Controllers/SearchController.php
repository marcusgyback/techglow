<?php

namespace App\Http\Controllers;

use App\Models\Product\Product;
use Illuminate\Http\Request;

class SearchController extends Controller
{

    public function index() {
        if(array_key_exists('query', $_GET)) {
            $searchQuery = $_GET['query'];

            $products = Product::selectRaw('*, MATCH(name) AGAINST(? IN BOOLEAN MODE) AS relevance', [$_GET['query']])
                ->whereRaw('MATCH(name) AGAINST(? IN BOOLEAN MODE) > 0', [$_GET['query']])
                ->paginate(15);
            $productsCount = Product::selectRaw('*, MATCH(name) AGAINST(? IN BOOLEAN MODE) AS relevance', [$_GET['query']])
                ->whereRaw('MATCH(name) AGAINST(? IN BOOLEAN MODE) > 0', [$_GET['query']])
                ->count();
        }else{
            $searchQuery = "";
            $productsCount = $products = null;
        }
        return view('frontend/webshop/searchresultspage', compact(['searchQuery', 'products', 'productsCount']));
    }

    public function autocomplete(Request $request) {
        $rows = Product::selectRaw('*, MATCH(name) AGAINST(? IN BOOLEAN MODE) AS relevance', [$request->get('query')])
                ->whereRaw('MATCH(name) AGAINST(? IN BOOLEAN MODE) > 0', [$request->get('query')])
                ->limit(5)
                ->get();

        $totalRows = Product::selectRaw('*, MATCH(name) AGAINST(? IN BOOLEAN MODE) AS relevance', [$request->get('query')])
            ->whereRaw('MATCH(name) AGAINST(? IN BOOLEAN MODE) > 0', [$request->get('query')])
            ->count();
        $data = [];
        foreach ($rows as $row)
        {
            $data[] = [
                "item_count" => $totalRows,
                "image" => $row->getImages()?->first()?->getUrl('thumbnail90'),
                "name" => $row->name,
                "slug" => $row->slug,
                //"price" => $row->getSellingPrice() / 100,
                ];
        }
        return response()->json($data);
    }
}
