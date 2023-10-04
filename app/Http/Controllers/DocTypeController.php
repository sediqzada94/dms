<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDocTypeRequest;
use App\Http\Requests\UpdateDocTypeRequest;
use App\Http\Resources\DocTypeResource;
use App\Models\DocType;
use Illuminate\Http\Request;

class DocTypeController extends Controller 
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
         return DocType::all();
    }


    public function create()
    {
         return 'doc type create view';
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDocTypeRequest $request)
    {
        $docType = DocType::create($request->validated());
        return $docType;
    }

    /**
     * Display the specified resource.
     */
    public function show(DocType $documentType)
    {
        return $documentType;
    }



    public function edit(DocType $documentType)
    {
        return $documentType;
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDocTypeRequest $request, DocType $documentType)
    {
        $documentType->update($request->validated());
        return $documentType;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DocType $documentType)
    {
           $deleted = $documentType->delete();
           if($deleted){
            return response()->json([
                'status' => '200',
                'message' => 'Document type deleted successfully'
            ]);
           }
    }
}
