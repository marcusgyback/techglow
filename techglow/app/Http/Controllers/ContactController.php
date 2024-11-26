<?php

namespace App\Http\Controllers;

use App\Models\Partner\Partner;
use App\Models\Support\Ticket;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
        $validateData = $request->validate([
            'email'         => 'required|email:rfc,dns',
            'message'       => 'required',
        ], [
            'email.required'        => 'Vänligen ange din e-mail adress',
            'message.required'      => 'Vändligen ange ett meddelande'
        ]);

        $contactModel = new Ticket();
        $contactModel->email = $request->email;
        $contactModel->question = $request->message;
        $contactModel->question_at = now();

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
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
