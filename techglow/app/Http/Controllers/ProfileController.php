<?php

namespace App\Http\Controllers;

use App\Models\Partner\Partner;
use App\Models\Profile\Address;
use App\Models\Profile\Customer;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        $customer = Customer::where('user_id', $user->id)->first();
        $levaddress = $customer->addresses()->where('shipping', 1)->get()->first();
        $billaddress = $customer->addresses()->where('billing', 1)->get()->first();
        $partnerInfo = Partner::where('user_id', $user->id)->first();

        return view('dashboard', compact(['user', 'customer', 'levaddress', 'billaddress', 'partnerInfo']));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $customerModel = new Customer();
        $userModel = new User();
        $addressModel = new Address();
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {

        $request->validate([
           'pass2' => 'same:pass1'
        ]);

        $fullname = $request->accountfn . ' ' . $request->accountln;
        $customer = Customer::where('user_id', $request->user()->id)->get()->first();
        $customer->update([
            "firstname" => $request->accountfn,
            "lastname"  => $request->accountln,
            "email"     => $request->accountemail,
            "phone"     => $request->accountphone
        ]);

        $customer->addresses()->where('shipping', 1)->get()->first()->update([
            "firstname"     => $request->accountfn,
            "lastname"      => $request->accountln,
            "address"       => $request->accountLevAddress,
            "postal_code"   => $request->accountLevPostalCode,
            "city"          => $request->accountLevCity
        ]);

        $customer->addresses()->where('billing', 1)->get()->first()->update([
            "firstname"     => $request->accountfn,
            "lastname"      => $request->accountln,
            "address"       => $request->accountBillAddress,
            "postal_code"   => $request->accountBillPostalCode,
            "city"          => $request->accountBillCity
        ]);

        if(isset($request->pass2)) {
            User::where('id', $request->user()->id)->get()->first()->update([
                'password' => bcrypt($request->pass2)
            ]);
        }

        return redirect()->back()->with('success', 'User updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function logout(Request $request) {
        auth('web')->logout();
        return redirect('/login');
    }
}
