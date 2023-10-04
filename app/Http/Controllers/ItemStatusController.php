<?php

namespace App\Http\Controllers;

use DB;
use App\Models\ItemStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ItemStatusController extends Controller
{
public function fetchitemstatus()
{
    $itemstatus = ItemStatus::all();
    return response()->json([
        'itemstatus'=>$itemstatus,
    ]);
}
public function store(Request $request)
{
    $validator = Validator::make($request->all(), [
        'name_en'=> 'required|max:191',
        'name_ps'=>'required|max:191',
        'name_prs'=>'required|max:191',
     
    ]);

    if($validator->fails())
    {
        return response()->json([
            'status'=>400,
            'errors'=>$validator->messages()
        ]);
    }
    else
    {
        $itemstatus = new ItemStatus;
        $itemstatus->name_en = $request->input('name_en');
        $itemstatus->name_ps = $request->input('name_ps');
        $itemstatus->name_prs = $request->input('name_prs');
        
        $itemstatus->save();
        return response()->json(['success'=>'itemstatus saved successfully.']);

    }

}
public function edit($id)
{
    $itemstatus = ItemStatus::find($id);
    if($itemstatus)
    {
        return response()->json([
            'status'=>200,
            'itemstatus'=> $itemstatus,
        ]);
    }
    else
    {
        return response()->json([
            'status'=>404,
            'message'=>'No measure Found.'
        ]);
    }

}
public function update(Request $request, $id)
{
    $validator = Validator::make($request->all(), [
        'name_en'=> 'required|max:191',
        'name_ps'=> 'required|max:191',
        'name_prs'=> 'required|max:191',
        
    ]);

    if($validator->fails())
    {
        return response()->json([
            'status'=>400,
            'errors'=>$validator->messages()
        ]);
    }
    else
    {
        $itemstatus = ItemStatus::find($id);
        if($itemstatus)
        {
            $itemstatus->name_en = $request->input('name_en');
            $itemstatus->name_ps = $request->input('name_ps');
            $itemstatus->name_prs = $request->input('name_prs');
            $itemstatus->update();
            return response()->json([
                'status'=>200,
                'message'=>'itemstatus Updated Successfully.'
            ]);
        }
        else
        {
            return response()->json([
                'status'=>404,
                'message'=>'No itemstatus Found.'
            ]);
        }

    }
}
public function destroy($id)
{
    $itemstatus = ItemStatus::find($id);
    if($itemstatus)
    {
        $itemstatus->delete();
        return response()->json([
            'status'=>200,
            'message'=>'itemstatus Deleted Successfully.'
        ]);
    }
    else
    {
        return response()->json([
            'status'=>404,
            'message'=>'No itemstatus Found.'
        ]);
    }
}
}
