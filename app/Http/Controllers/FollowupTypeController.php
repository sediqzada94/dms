<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreFollowupTypeRequest;
use App\Http\Requests\UpdateFollowupTypeRequest;
use App\Http\Resources\FollowupTypeResource;
use App\Models\FollowupType;
use Illuminate\Http\Request;

class FollowupTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index() 
    {
        return FollowupType::all();
    }


    public function create() 
    {
        return 'followup type create view';
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreFollowupTypeRequest $request)
    {
        $followup_types = FollowupType::create($request->validated());
        return $followup_types;
    }

    /**
     * Display the specified resource.
     */
    public function show(FollowupType $followup_type)
    {
        return $followup_type;
    }



    public function edit(FollowupType $followup_type)
    {
        return $followup_type;
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateFollowupTypeRequest $request, FollowupType $followup_type)
    {
        $followup_type->update($request->validated());
        return $followup_type;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(FollowupType $followup_type)
    {
           $deleted = $followup_type->delete();
           if($deleted){
            return response()->json([
                'status' => '200',
                'message' => 'Followup type deleted successfully'
            ]);
           }
    }
}
