<?php

namespace App\Http\Controllers;

use App\Company;
use App\Document;
use Illuminate\Http\Request;

class CompaniesController extends Controller
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
     * Display the specified resource.
     *
     * @param  \App\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function show(Company $company)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function edit(Company $company)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Company $company)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function destroy(Company $company)
    {
        //
    }

    /**
     * Saves company related marketing documents
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function saveDocuments(Request $request, Company $company)
    {
        $path = $request->file->store(
            'tmp/documents', 's3'
        );

        try {
            $document = new Document;
            $document->name = $request->file->getClientOriginalName();
            $document->file = 'http://dy01r176shqrv.cloudfront.net/' . $path;

            $company->documents()->save($document);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 422);
        }

        return response()->json(['message' => 'Company document successfully uploaded.'], 200);
    }

    /**
     * upload a company document
     * @param  [type] $document [description]
     * @return [type]           [description]
     */
    protected function uploadFile($document)
    {
        $path = $document->store('public/documents');
        return explode("/",$path)[2];
    }
}
