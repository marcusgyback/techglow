<?php

use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ProductsFeedController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PartnerController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\EmailValidationController;
use App\Http\Controllers\PartnerSubscribersController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SearchController;
use App\Http\Middleware\SetPartnerCookie;
use App\Models\Languages;
use App\Models\Partner\Partner;
use App\Models\Product\Product;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\App;
use App\Http\Controllers;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/



Route::get('/i18n/{locale}', function ($locale) {
    if (! in_array($locale, array_keys(config('app.available_locales')))) {
        abort(400);
    }
    App::setLocale($locale);
    session()->put('locale', $locale);
    return redirect()->back();
});

Route::get('/', function () {
    $partners = Partner::inRandomOrder()->where('active', '=', 1)->take(4)->get();
    $OpeningPartners = Partner::inRandomOrder()->where('active', '=', 1)->take(3)->get();
    $campaignProducts = Product::inRandomOrder()->where('show_on_start_page', '=', 1)->where('campaign_product', '=', 1)->take(8)->get();
    $startPageProducts = Product::InRandomOrder()->where('show_on_start_page', '=', 1)->where('campaign_product', '=', 0)->take(8)->get();

    return view('frontend/webshop/frontpage', compact(['OpeningPartners', 'partners', 'campaignProducts', 'startPageProducts']));
})->middleware(SetPartnerCookie::class);
Route::get('/terms', function() {
    return view('frontend/webshop/terms');
});
Route::get('/contact', function() {
    return view('frontend/webshop/contact');
})->name('contact');
Route::post('/contact/question/add', [ContactController::class, 'store'])->name('store.contact');

Route::get('/thankyou', function() {
    return view('frontend/webshop/thankyou');
});
// Partner-routes
Route::get('/partner-registration', function() {
    return view('frontend/partner/registration');
})->name('partner-registration')->middleware(SetPartnerCookie::class);
Route::post('/store/partner', [PartnerController::class, 'store'])->name('store.partner');
Route::post('/partner/validation/{code}/{id}', [EmailValidationController::class, 'validation'])->name('store.validation');
Route::post('/store/subscriber', [PartnerSubscribersController::class, 'store'])->name('store.subscriber');

// Product-routes
Route::get('/product/{slug}', [ProductsController::class, 'show'])->middleware(SetPartnerCookie::class)->name("product.show");
Route::post('/product/{id}', [ProductsController::class, 'update'])->name("product.update");
Route::get('/cart', function() {
   return view('frontend/webshop/cart');
})->name('view.cart')->middleware(SetPartnerCookie::class);
Route::get('/add-to-cart/{id}', [ProductsController::class, 'addToCart'])->name('add.to.cart');
Route::delete('/remove-from-cart/', [ProductsController::class, 'removeFromCart'])->name('remove.from.cart');

// Checkout routes
Route::get('/checkout/', [CheckoutController::class, 'index'])->name('checkout')->middleware(SetPartnerCookie::class);
Route::post('/callback/hygglig/{orderId}/{orderPin}/', [CheckoutController::class, 'callback']);

// Profile routes
Route::get('/register', [UserController::class, 'show'])->name('show')->middleware(SetPartnerCookie::class);
Route::post('/createcustomeranduser', [UserController::class, 'createCustomerAndUser'])->name('create.profile');
Route::post('/store/profile', [ProfileController::class, 'store'])->name('store.profile');
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dashboard', [ProfileController::class, 'index'])->name('dashboard');
    Route::post('/update/profile', [ProfileController::class, 'update'])->name('update.profile');
    Route::get('/logout', [ProfileController::class, 'logout'])->name('logout');
});


// Search routes
Route::get('/autocomplete', [SearchController::class, 'autocomplete'])->name('autocomplete');
Route::get('/search', [SearchController::class, 'index'])->name('searchResults');
// Product Feeds
Route::get('/productfeed/type/csvprisjakt', [ProductsFeedController::class, 'csvPrisjakt']);

Route::get('/c/{slug}',[Controllers\CategoriController::class, 'show'])
    ->where(['slug' => '^((?!admin)(?!nova-api)(?!nova-vendor).)*$'])
    ->name('{{categori.show}}');



Route::get('{slug}',[Controllers\PageController::class, 'show']);
/*    ->where(['slug' => '^((?!admin)(?!nova-api)(?!nova-vendor).)*$'])
    ->name('{{frontPageRouteName}}');
/**/
