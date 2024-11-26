<?php

namespace App\Http\Controllers;


use App\Models\Order\Order;
use App\Models\Order\OrderRow;
use App\Models\Order\OrderShippingAddress;
use App\Models\Partner\Partner;
use App\Models\Product\Product;
use App\Models\Profile\Customer;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ServerException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    public function index() {

        if (!Auth::check()) {
            return redirect('/login');
        }

        $customer = Customer::where('user_id', Auth::user()->id)->get()->first();
        $customerAddress = $customer->addresses()->where('shipping', true)->get()->first();

        if(empty(session()->get('order'))) {
            $order = Order::create([
                'order_status' => 'offer',
                'payment_status' => 'waiting',
                'customer_id' => $customer->id,
                'user_id' => Auth::user()->id,
                'payment_provider_id' => 1,
                'send_invoiuce' => 'email',
                'pin' => rand(1000, 9999)
            ]);

            session()->put('order', $order->id);
        } else {
            $order = Order::find(session()->get('order'));
        }

        $subTotal = 0;
        $vat = 0;

        foreach(session('cart') as $id => $details) {
            $subTotal +=$details['price']*$details['quantity'];
            $vat = $subTotal*0.2;
        }

        $order->subtotal = $subTotal;
        $order->vat = $vat;

        $order->save();

        foreach(session('cart') as $id => $details) {
            $product = Product::where('our_art_no', $details['artno'])->get()->first();

            $partner_id = null;

            if(isset($_COOKIE['partner'])) {
                $partner = Partner::where('twitch_url', $_COOKIE['partner'])->where('active', true)->get()->first();
                $partner_id = $partner->id;
            }

            $orderRow = OrderRow::updateOrCreate([
                'order_id'          => $order->id,
                'supplier_id'       => 1,
                'supplier_art_no'   => $product->bb_sku,
                'art_no'            => $details['artno'],
                'name'              => $details['name'],
                'quantity'          => $details['quantity'],
                'unit'              => 'pcs',
                'unit_price'        => $details['price'],
                'discount'          => 0,
                'amount'            => $details['price'],
                'vat'               => $details['price']*0.2,
                'vat_percent'       => 25,
                'vat_reverse'       => false,
                'partner_id'        => $partner_id,
                //'discount_code'     => null,
                //'discount_code_id   => null,
            ]);
        }

        $url = env('HYGGLIG_URL');
        $eid = env('HYGGLIG_EID');
        $secret = env('HYGGLIG_SECRET');

        $client = new Client();

        $body = [
            "success_url" => "https://www.techglow.se/thankyou",
            "push_notification_url" => "https://www.techglow.se/callback/hygglig/".$order->id.'/'.$order->pin.'/',
            "checkout_url" => "https://www.techglow.se/checkout",
            "terms_url" => "https://www.techglow.se/terms",
            "order_reference" => 'b12'.$order->id,
            "currency" => "SEK",
            "billing_info" => [
                "national_identity_number" => $customer->ssn,
                "first_name" => $customer->firstname,
                "last_name" => $customer->lastname,
                "address" => $customerAddress->address,
                "phone" => $customer->phone,
                "postal_code" => $customerAddress->postal_code,
                "city" => $customerAddress->city,
                "state" => $customerAddress->state,
                "country" => $customerAddress->country,
                "email" => $customer->email
            ],
            "articles" => [

            ]
        ];

        $shippingAddress = OrderShippingAddress::updateOrCreate([
            'order_id' => $order->id,
            "firstname" => $customer->firstname,
            "lastname" => $customer->lastname,
            "address" => $customerAddress->address,
            "postal_code" => $customerAddress->postal_code,
            "city" => $customerAddress->city,
            "state" => $customerAddress->state,
            "country" => $customerAddress->country,
            "email" => $customer->email,
            "phone" => $customer->phone,
        ]);

        foreach(session('cart') as $id => $details) {
            $article = [
                "article_name" => str_replace("/", "", $details['name']),
                "article_number" => $details['artno'],
                "description" => strip_tags(substr($details['description'],0,190)),
                "price" => $details['price'] * 100,
                "quantity" => $details['quantity'],
                "vat" => $details['vat'],
            ];

            $body['articles'][] = $article;
        }

        $options = [
            'auth' => [
                $eid,
                $secret
            ],
            'verify' => false,
            'headers' => ['content-type' => 'application/json', 'Accept' => 'application/json'],
            'body' => json_encode($body),
            'debug' => false
        ];

        try {
            $res = $client->post($url.'api/checkout', $options);
            $cleanResponse = json_decode($res->getBody()->getContents());

            $order->payment_provider_ref = $cleanResponse->order_number;
            $order->save();

            $html_snippet = $cleanResponse->html_snippet;
        } catch (ServerException $e) {
            var_dump($e->getRequest());
        }

        return view('frontend/webshop/checkout', compact('html_snippet'));
    }

    public function callback(Request $request, $orderId, $orderPin) {
        Order::where('id', $orderId)->where('pin', $orderPin)->update(["order_status" => "invoice", "payment_status" => "payed"]);
    }
}
