<?php

namespace App\Http\Controllers;

use DB;
use App\Models\ItemType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ItemTypesController extends Controller
{
public function fetchitemtype()
{
    $item_type = ItemType::all();
    return response()->json([
        'item_type'=>$item_type,
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
        $itemtype = new ItemType;
        $itemtype->name_en = $request->input('name_en');
        $itemtype->name_ps = $request->input('name_ps');
        $itemtype->name_prs = $request->input('name_prs');
        
        $itemtype->save();
        // return response()->json([
        //     'status'=>200,
        //     'message'=>'itemtype Added Successfully.'
        // ]);
        return response()->json(['success'=>'itemtype saved successfully.']);

    }

}
public function edit($id)
{
    $itemtype = ItemType::find($id);
    if($itemtype)
    {
        return response()->json([
            'status'=>200,
            'itemtype'=> $itemtype,
        ]);
    }
    else
    {
        return response()->json([
            'status'=>404,
            'message'=>'No itemtype Found.'
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
        $itemtype = ItemType::find($id);
        if($itemtype)
        {
            $itemtype->name_en = $request->input('name_en');
            $itemtype->name_ps = $request->input('name_ps');
            $itemtype->name_prs = $request->input('name_prs');
            $itemtype->update();
            return response()->json([
                'status'=>200,
                'message'=>'itemtype Updated Successfully.'
            ]);
        }
        else
        {
            return response()->json([
                'status'=>404,
                'message'=>'No itemtype Found.'
            ]);
        }

    }
}

public function destroy($id)
{
    $itemtype = ItemType::find($id);
    if($itemtype)
    {
        $itemtype->delete();
        return response()->json([
            'status'=>200,
            'message'=>'itemtype Deleted Successfully.'
        ]);
    }
    else
    {
        return response()->json([
            'status'=>404,
            'message'=>'No itemtype Found.'
        ]);
    }
}
}
