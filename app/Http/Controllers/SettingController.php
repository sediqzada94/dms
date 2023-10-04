<?php

namespace App\Http\Controllers;
use DB;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

class SettingController extends Controller
{
public function index()
{
    $Categories=DB::table('categories')->get();
    $itm_type=DB::table('item_types')->get();
    $employee=DB::table('employees')->get();
    $hangar=DB::table('hangars')->get();
    
    $unitofmeasure=DB::table('unit_of_measures')->get();
    return view("settings.index",['Categories'=>$Categories,'itm_type'=>$itm_type,'unitofmeasure'=>$unitofmeasure,'employee'=>$employee,'hangar'=>$hangar]);
}
public function create()
{
    
}
public function fetchsetting()
{
    $categories = Category::all();
    return response()->json([
        'categories'=>$categories,
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
        $category = new Category;
        $category->name_en = $request->input('name_en');
        $category->slug = Str::slug($category->name_en);
        $category->name_ps = $request->input('name_ps');
        $category->name_prs = $request->input('name_prs');
        
        $category->save();
        updateCreatedByOrUpdatedBy('categories','created_by');
        return response()->json(['success'=>'Category saved successfully.']);

    }

}

public function edit($id)
{
    $category = Category::find($id);
    if($category)
    {
        return response()->json([
            'status'=>200,
            'category'=> $category,
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
        $category = Category::find($id);
        if($category)
        {
            $category->name_en = $request->input('name_en');
            $category->name_ps = $request->input('name_ps');
            $category->name_prs = $request->input('name_prs');
            $category->update();
            updateCreatedByOrUpdatedBy('categories','updated_by',$category->id);
            return response()->json([
                'status'=>200,
                'message'=>'category Updated Successfully.'
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
    $category = Category::find($id);
    if($category)
    {
        $category->delete();
        return response()->json([
            'status'=>200,
            'message'=>'category Deleted Successfully.'
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


