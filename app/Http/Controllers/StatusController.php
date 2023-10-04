<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreStatusRequest;
use App\Http\Requests\UpdateStatusRequest;
use App\Http\Resources\StatusResource;
use App\Models\Status;
use Illuminate\Http\Request;

class StatusController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index() 
    {
        return Status::all();
    }


    public function create() 
    {
        return 'status create view';
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreStatusRequest $request)
    {
        $statuses = Status::create($request->validated());
        return $statuses;
    }

    /**
     * Display the specified resource.
     */
    public function show(Status $status)
    {
        return $status;
    }



    public function edit(Status $status)
    {
        return $status;
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateStatusRequest $request, Status $status)
    {
        $status->update($request->validated());
        return $status; 
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Status $status)
    {
           $deleted = $status->delete();
           if($deleted){
            return response()->json([
                'status' => '200',
                'message' => 'Status type deleted successfully'
            ]);
           }
    }
}
