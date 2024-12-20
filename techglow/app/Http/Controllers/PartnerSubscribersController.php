<?php

namespace App\Http\Controllers;

use App\Models\Partner\PartnerSubscriber;
use Illuminate\Http\Request;

class PartnerSubscribersController extends Controller
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
        $partnerSubModel = new PartnerSubscriber;
        $partnerSubModel->email = $request->email;
        $partnerSubModel->save();

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PartnerSubscriber  $PartnerSubscriber
     * @return \Illuminate\Http\Response
     */
    public function show(PartnerSubscriber $PartnerSubscriber)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PartnerSubscriber  $PartnerSubscriber
     * @return \Illuminate\Http\Response
     */
    public function edit(PartnerSubscriber $PartnerSubscriber)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PartnerSubscriber  $PartnerSubscriber
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PartnerSubscriber $PartnerSubscriber)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PartnerSubscriber  $PartnerSubscriber
     * @return \Illuminate\Http\Response
     */
    public function destroy(PartnerSubscriber $PartnerSubscriber)
    {
        //
    }
}
