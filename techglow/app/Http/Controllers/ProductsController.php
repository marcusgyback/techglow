<?php

namespace App\Http\Controllers;

use App\Models\Cart\Cart;
use App\Models\Product\Product;
use Illuminate\Http\Request;
use App\Helpers\KemTaxCalculation;
use \Log;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        $product = Product::where('slug', $slug)->firstOrFail();
        return view('frontend/webshop/productpage', compact('product'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        if(\Auth::check() && \Auth::user()->isAdministrator())
        {
            $product = Product::findOrFail($id);
            $selling_price = $request->get('selling_price', null);
            $bb_sku = $request->get('bb_sku', null);
            $despec_sku = $request->get('despec_sku', null);
            $published = $request->get('published', null);
            $margin_target = $request->get('margin_target', null);
            $kem_tax = $request->get('kem_tax', null);


            $new_selling_price = $selling_price * 100;
            $save = false;
            if(!is_null($selling_price) && is_numeric($selling_price) && ($product->selling_price !==$new_selling_price))
            {
                Log::info('Price update by user id ' .  \Auth::user()->id . ' on product id ' . $product->id . ' from ' . $product->selling_price  . ' to ' . ($selling_price * 100));
                $product->selling_price = ($selling_price * 100);
                $save = true;
            }

            if(!is_null($bb_sku) && ($product->bb_sku !== $bb_sku))
            {
                Log::info('BigBuy SKU update by user id ' .  \Auth::user()->id . ' on product id ' . $product->id . ' from ' . $product->bb_sku  . ' to ' . $bb_sku);
                $product->bb_sku = $bb_sku;
                $save = true;
            }

            if(!is_null($despec_sku) && ($product->despec_sku !== $despec_sku))
            {
                Log::info('Despec SKU update by user id ' .  \Auth::user()->id . ' on product id ' . $product->id . ' from ' . $product->despec_sku  . ' to ' . $despec_sku);
                $product->despec_sku = $despec_sku;
                $save = true;
            }

            if(!is_null($published) && ($product->published !== $published))
            {
                Log::info('published status update by user id ' .  \Auth::user()->id . ' on product id ' . $product->id . ' from ' . $product->published  . ' to ' . $published);
                $product->published = $published;
                $save = true;
            }

            if(!is_null($margin_target) && ($product->margin_target !== $margin_target))
            {
                Log::info('published status update by user id ' .  \Auth::user()->id . ' on product id ' . $product->id . ' from ' . $product->margin_target  . ' to ' . $margin_target);
                $product->margin_target = $margin_target;
                $save = true;
            }

            if(!is_null($kem_tax) && ($product->kem_tax !== $kem_tax))
            {
                Log::info('kem_tax type update by user id ' .  \Auth::user()->id . ' on product id ' . $product->id . ' from ' . $product->kem_tax  . ' to ' . $kem_tax);
                $product->kem_tax = $kem_tax;
                $product->kem_tax_amount = KemTaxCalculation::Calculate($product->kem_tax, $product->weight);
                $save = true;
            }

            if($save){
                $product->save();
            }
            return redirect()->back();
        }
        else
        {
            abort(404);
        }
    }




    /**
     * Add product to cart session
     *
     * @param $id;
     * @return response();
     */
    public function addToCart($id) {
        $product = Product::findOrFail($id);
        $cart = session()->get('cart', []);
        $cartTotal = 0;
        if(isset($cart[$id])) {
            $cart[$id]['quantity']++;
        } else {

            $vat = 0;

            if($product->vat_reverse === false) {
                if($product->vat_class_se === '25_percent') {
                    $vat = 2500;
                } else if($product->vat_class_se === '12_percent') {
                    $vat = 1200;
                } else if($product->vat_class_se === '6_percent') {
                    $vat = 600;
                }
            }

            $cart[$id] = [
                "artno"         => $product->our_art_no,
                "name"          => $product->name,
                "quantity"      => 1,
                "price"         => $product->getSellingPrice(),
                "description"   => $product->description,
                "vat"           => $vat,
            ];

            foreach($cart as $item) {
                $cartTotal += ($item['price'] * $item['quantity'] / 100);
            }

            if($cartTotal <= 2500) {
                if (empty($cart["Frakt"])) {
                    $cart["Frakt"] = [
                        "artno" => "1000",
                        "name" => "Frakt",
                        "quantity" => 1,
                        "price" => 28900,
                        "description" => "Fraktkostnad",
                        "vat" => 2500,
                    ];
                }
            } else {
                unset($cart["Frakt"]);
            }
        }

        session()->put('cart', $cart);
        return redirect()->back();
    }

    /**
     * Remove product from cart session
     *
     * @param $id;
     * @return response();
     */
    public function removeFromCart(Request $request) {
        if($request->id) {
            $cart = session()->get('cart');
            if(isset($cart[$request->id])) {
                unset($cart[$request->id]);

                if(count($cart) === 1 && array_key_exists("Frakt", $cart)) {
                    unset($cart["Frakt"]);
                }
                $cartTotal = 0;

                if($cartTotal <= 2500) {
                    if (empty($cart["Frakt"])) {
                        $cart["Frakt"] = [
                            "artno" => "1000",
                            "name" => "Frakt",
                            "quantity" => 1,
                            "price" => 28900,
                            "description" => "Fraktkostnad",
                            "vat" => 2500,
                        ];
                    }
                }

                if($cartTotal === 0) {
                    unset($cart["Frakt"]);
                }

                session()->put('cart', $cart);
            }
        }
    }
}
