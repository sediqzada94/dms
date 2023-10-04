<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSecurityLevelRequest;
use App\Http\Requests\UpdateSecurityLevelRequest;
use App\Http\Resources\SecurityLevelResource;
use App\Models\SecurityLevel;
use Illuminate\Http\Request;

class SecurityLevelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index() 
    {
        return SecurityLevel::all();
    }


    public function create() 
    {
        return "security level create view";
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSecurityLevelRequest $request)
    {
        $security_level = SecurityLevel::create($request->validated());
        return $security_level;
    }

    /**
     * Display the specified resource.
     */
    public function show(SecurityLevel $security_level)
    {
        return $security_level;
    }


    public function edit(SecurityLevel $security_level)
    {
        return $security_level;
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSecurityLevelRequest $request, SecurityLevel $security_level)
    {
        $security_level->update($request->validated());
        return $security_level;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SecurityLevel $security_level)
    {
           $deleted = $security_level->delete();
           if($deleted){
            return response()->json([
                'status' => '200',
                'message' => 'SecurityLevel type deleted successfully'
            ]);
           }
    }
}
