<?php

namespace App\Http\Controllers;

use App\Stand;
use Exception;
use Illuminate\Http\Request;

class StandsController extends Controller
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
        //
    }

    /**
     * it assigns a company
     * @param  Stand  $stand [description]
     * @return [type]        [description]
     */
    public function reserve(Stand $stand, Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'logo_file' => 'required|image',
            'address' => 'required',
            'phone' => 'required',
            'admin_name' => 'required',
            'admin_email' => 'required|email'
        ]);
        
        $file = $request->file('logo_file');
        $path = $request->logo_file->store('public/logos');
        $filename = explode("/",$path)[2];
        
        $request->merge(['logo' => "/logos/{$filename}" ]);
        $company_attribute = $request->except('logo_file');

        try {
            $company = $stand->assignCompany($company_attribute);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 422);
        }
        
        return response()->json(['message' => 'You have successfully reserved this stand', 'event_id' => $stand->event->id, 'company_id'=>$company->id ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Stand  $stand
     * @return \Illuminate\Http\Response
     */
    public function show(Stand $stand)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Stand  $stand
     * @return \Illuminate\Http\Response
     */
    public function edit(Stand $stand)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Stand  $stand
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Stand $stand)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Stand  $stand
     * @return \Illuminate\Http\Response
     */
    public function destroy(Stand $stand)
    {
        //
    }
}
