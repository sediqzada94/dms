<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use DB;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SubCategoryController extends Controller
{
 public function index()
{
    $Categories=DB::table('categories')->get();
   return view("subcategory.subcategory",['Categories'=>$Categories]);
}
public function fetchsubcategory()
{
    $subcategories = SubCategory::with(['category'])->get();
    return response()->json([
        'subcategories'=>$subcategories,
    ]);
}
public function store(Request $request)
{
    $validator = Validator::make($request->all(), [
        'category_id'=> 'required|max:191',
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
        $subcategory = new SubCategory;
        $subcategory->category_id = $request->input('category_id');
        $subcategory->name_en = $request->input('name_en');
        $subcategory->name_ps = $request->input('name_ps');
        $subcategory->name_prs = $request->input('name_prs');
        
        $subcategory->save();
        return response()->json(['success'=>'Sub Category saved successfully.']);

    }

}
public function edit($id)
{
   $subcategory = SubCategory::with(['category'])->find($id);
     if($subcategory)
    {
        return response()->json([
            'status'=>200,
            'subcategory'=> $subcategory,
        ]);
    }
    else
    {
        return response()->json([
            'status'=>404,
            'message'=>'No subcategory Found.'
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
        $subcategory = SubCategory::find($id);
        if($subcategory)
        {
            $subcategory->category_id = $request->input('category_id');
            $subcategory->name_en = $request->input('name_en');
            $subcategory->name_ps = $request->input('name_ps');
            $subcategory->name_prs = $request->input('name_prs');
            $subcategory->update();
            return response()->json([
                'status'=>200,
                'message'=>'subcategory Updated Successfully.'
            ]);
        }
        else
        {
            return response()->json([
                'status'=>404,
                'message'=>'No category Found.'
            ]);
        }

    }
}

public function destroy($id)
{
    $subcatcategory = SubCategory::find($id);
    if($subcatcategory)
    {
        $subcatcategory->delete();
        return response()->json([
            'status'=>200,
            'message'=>'subcatcategory Deleted Successfully.'
        ]);
    }
    else
    {
        return response()->json([
            'status'=>404,
            'message'=>'No subcatcategory Found.'
        ]);
    }
}
}
