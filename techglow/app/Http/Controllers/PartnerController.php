<?php

namespace App\Http\Controllers;

use App\Models\Partner\Partner;
use Illuminate\Http\Request;

class PartnerController extends Controller
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
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $validateData = $request->validate([
            'first_name'    => 'required|min:3',
            'last_name'     => 'required|min:3',
            'email'         => 'required|email:rfc,dns',
            'email2'        => 'required_with:email|same:email',
            'address'       => 'required|min:5',
            'postal_code'   => 'required|min:4|max:6',
            'city'          => 'required|min:2',
            'ssn'           => 'required|min:10',
        ], [
            'first_name.required'   => 'Vänligen ange ditt förnamn',
            'first_name.min'        => 'Ditt förnamn måste vara minst 3 tecken',
            'last_name.required'    => 'Vänligen ange ditt efternamn',
            'last_name.min'         => 'Ditt efternamn måste vara minst 3 tecken',
            'email.required'        => 'Vänligen ange din e-mail adress',
            'email.dns'             => 'Det ser ut som att du angivit en felaktig email',
            'address.required'      => 'Vänligen ange din hemaddress',
            'address.min'           => 'Din adress måste vara minst 5 tecken lång',
            'postal_code.required'  => 'Vänligen ange ditt postnummer',
            'postal_code.min'       => 'Postnumret måste vara minst 5 tecken långt',
            'postal_code.max'       => 'Postnumret får max vara 6 tecken långt',
            'ssn.required'          => 'Ditt personnummer måste vara minst 10 tecken långt',
            'ssn.min'               => 'Ditt personnummer måste vara minst 10 tecken långt',
        ]);

        $partnerModel = new Partner;

        $partnerModel->active = 0;
        $partnerModel->partner_image = '';
        $partnerModel->first_name = $request->first_name;
        $partnerModel->last_name = $request->last_name;
        $partnerModel->ssn = $request->ssn;
        $partnerModel->email = $request->email;
        $partnerModel->phone = $request->mobile;
        $partnerModel->address = $request->address;
        $partnerModel->postal_code = $request->postal_code;
        $partnerModel->city = $request->city;
        $partnerModel->email_validate_code = uuid_create(\UUID_TYPE_RANDOM);
        $partnerModel->twitch_url = $request->twitch_url;
        $partnerModel->youtube_url = $request->youtube_url;
        $partnerModel->instagram_url = $request->instagram_url;
        $partnerModel->facebook_url = $request->facebook_url;
        $partnerModel->save();

        return redirect()->back()->with('success', 'Din ansökan är nu skickad');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
