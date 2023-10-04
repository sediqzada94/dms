<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDeadlineTypeRequest;
use App\Http\Requests\UpdateDeadlineTypeRequest;
use App\Http\Resources\DeadlineTypeResource;
use App\Models\DeadlineType;
use Illuminate\Http\Request;

class DeadlineTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index() 
    {
        return DeadlineType::all();
    }


    public function create() 
    {
        return 'deadline type create view';
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDeadlineTypeRequest $request)
    {
        $deadline_type = DeadlineType::create($request->validated());
        return $deadline_type;
    }

    /**
     * Display the specified resource.
     */
    public function show(DeadlineType $deadline_type)
    {
        return $deadline_type;
    }


    public function edit(DeadlineType $deadline_type)
    {
        return $deadline_type;
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDeadlineTypeRequest $request, DeadlineType $deadline_type)
    {
        $deadline_type->update($request->validated());
        return $deadline_type;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DeadlineType $deadline_type)
    {
           $deleted = $deadline_type->delete();
           if($deleted){
            return response()->json([
                'status' => '200',
                'message' => 'Deadline type deleted successfully'
            ]);
           }
    }
}
