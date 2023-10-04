<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTrackerRequest;
use App\Http\Requests\UpdateTrackerRequest;
use App\Http\Resources\TrackerResource;
use App\Models\Tracker;
use Illuminate\Http\Request;

class TrackerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index() 
    {
        return Tracker::paginate(2);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTrackerRequest $request)
    {
        $tracker = Tracker::create($request->validated());
        return response()->json([
            'tracker' => $tracker,
            'status' => 200,
            'message' => __('general_words.record_saved'),
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Tracker $tracker, Request $request)
    { 

        return $tracker;


        // $tracks = Tracker::where('document_id', $tracker->document_id);
        // if (!empty($request->inNumber)) {
        //     $tracks->where('in_num','like', '%'.$request->inNumber.'%');
        // }
        
        // if (!empty($request->outNumber)) {
        //     $tracks->where('out_num','like', '%'.$request->remark.'%');
        // }
        
        // if (!empty($request->inDate)) {
        //     $tracks->where('in_date', $request->inDate);
        // }
        
        // if (!empty($request->outDate)) {
        //     $tracks->where('out_date', $request->outDate);
        // }
        
        // if (!empty($request->remark)) {
        //     $tracks->where('remark','like', '%'.$request->remark.'%');
        // }
        
        // $tracks = $tracks->get();
        
        // return TrackerResource::collection($tracks);
    }



    public function edit(Tracker $tracker)
    {
        $tracker = $tracker->load(['sender', 'receiver', 'docType', 'deadline', 'deadlineType',
         'followupType', 'securityLevel', 'status']);
         return $tracker;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTrackerRequest $request, Tracker $tracker)
    {
         $tracker->update($request->validated());
         $tracker->load(['sender', 'receiver', 'docType', 'deadline', 'deadlineType',
                        'followupType', 'securityLevel', 'status']);
        return response()->json([
            'tracker' => $tracker,
            'status' => 200,
            'message' => __('general_words.record_updated'),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tracker $tracker)
    {
           $deleted = $tracker->delete();
           if($deleted){
            return response()->json([
                'status' => '200',
                'message' => 'Tracker deleted successfully'
            ]);
           }
    }
}
