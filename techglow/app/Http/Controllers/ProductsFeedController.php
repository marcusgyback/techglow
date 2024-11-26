<?php

namespace App\Http\Controllers;

use App\Models\Product\Menu;
use App\Models\Product\Product;
use Illuminate\Http\Request;

class ProductsFeedController extends Controller
{

    protected function menuToCategory($menuId, $path = []) {
        $menu = Menu::where('id', '=', $menuId)->get()->first();
        $path[] = $menu->title;

        if(!is_null($menu->parent_id)) {
            $path = $this->menuToCategory($menu->parent_id, $path);
        }

        return $path;
    }

    public function csvPrisjakt() {
        $fileName = "products_".date('Y-m-d H:i:s').".csv";
        $headers = [
            "Content-type"              =>  "text/csv",
            "Content-Disposition"       =>  "attachment; filename=$fileName",
            "Pragma"                    =>  "no-cache",
            "Cache-Control"             =>  "must-revalidate, post-check=0, pre-check=0",
            "expires"                   =>  "0",
        ];

        $columns = [
            'availability',
            'condition',
            'id',
            'link',
            'price',
            'title',
            'image_link',
            'gtin',
            'product_type'
        ];

        $products = Product::where('menu_id', '=' , 15)
            ->orWhere('menu_id', '=', 11)
            ->orWhere('menu_id', '=', 19)
            ->Where('published', '=', 1)
            ->get();

        $callback = function() use($products, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach($products as $product) {

                $menuId = $product->menu_id;
                $menuPath = implode(" > ", array_reverse($this->menuToCategory($menuId)));

                $productImage = "";
                foreach((object)$product->getImages() as $image) {
                    $productImage = $image->getUrl('productpage');
                }

                if($product->stock > 0) {
                    $availability = 'in_stock';
                } else {
                    $availability = 'out_of_stock';
                }

                $row['availability'] = $availability;
                $row['condition'] = "new";
                $row['id'] = $product->our_art_no;
                $row['link'] = "https://www.techglow.se/product/".$product->slug.'/';
                $row['price'] = number_format((float)$product->selling_price / 100, 2, '.', '').' SEK';
                $row['title'] = $product->name;
                $row['image_link'] = $productImage;
                $row['gtin'] = $product->ean;
                $row['product_type'] = $menuPath;

                fputcsv($file, array(
                    $row['availability'],
                    $row['condition'],
                    $row['id'],
                    $row['link'],
                    $row['price'],
                    $row['title'],
                    $row['image_link'],
                    $row['gtin'],
                    $row['product_type']),
                );
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
