<?php

namespace App\Http\Controllers;

use App\Models\Profile\Address;
use App\Models\Profile\Customer;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{

    public function show() {
        return view('auth/register');
    }

    public function createCustomerAndUser(Request $request) {

        $request->validate([
            "ssn"           => "required|min:10|max:13",
            "firstname"     => "required|min:2",
            "lastname"      => "required|min:3",
            "email"         => ["email:rfc,dns"],
            "email2"        => "required|same:email",
            "pass1"         => "required|min:6",
            "pass2"         => "required|same:pass1",
            "mobilephone"   => "required|min:10|max:13"
        ]);

        $fullName = $request->firstname.' '.$request->lastname;

        $userId = User::insertGetId([
            'name' => $fullName,
            'email' => $request->email,
            'password' => bcrypt($request->pass2),
            "created_at" => date("Y-m-d H:i:s"),
            "updated_at" => date("Y-m-d H:i:s"),
        ]);

        $customerId = Customer::insertGetId([
            'user_id' => $userId,
            'ssn' => $request->ssn,
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
            'email' => $request->email,
            'phone' => $request->mobilephone,
            "created_at" => date("Y-m-d H:i:s"),
            "updated_at" => date("Y-m-d H:i:s"),
        ]);

        Address::insertGetId([
            'customer_id' => $customerId,
            'billing' => 1,
            'shipping' => 0,
            "created_at" => date("Y-m-d H:i:s"),
            "updated_at" => date("Y-m-d H:i:s"),
        ]);
        Address::insertGetId([
            'customer_id' => $customerId,
            'billing' => 0,
            'shipping' => 1,
            "created_at" => date("Y-m-d H:i:s"),
            "updated_at" => date("Y-m-d H:i:s"),
        ]);

        return redirect()->route('login');
    }
}
