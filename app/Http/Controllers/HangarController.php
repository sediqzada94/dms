<?php

namespace App\Http\Controllers;

use DB;
use App\Models\Hangar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class HangarController extends Controller
{

    protected $hangar;
    public function __construct(Hangar $hangar)
    {
        $this->hangar   = $hangar;
    }
    public function index(Request $request){
        // $data['directorates'] = (new Directorate())->getDirectorate();
        if ($request->ajax()) {
            return $this->hangar->hangarList($request);
        }
        return view('settings.hangars.index');
    }
    public function fetchhangar()
    {
    $hangars = Hangar::all();
    return response()->json([
        'hangars'=>$hangars,
    ]);
}
public function store(Request $request)
{
    // $validator = Validator::make($request->all(), [
    //     'name_en'=> 'required|max:191',
    //     'name_ps'=>'required|max:191',
    //     'name_prs'=>'required|max:191',
    //     'description'=>'required|max:191',
     
    // ]);

    // if($validator->fails())
    // {
    //     return response()->json([
    //         'status'=>400,
    //         'errors'=>$validator->messages()
    //     ]);
    // }
    // else
    // {
    //     $hangars = new Hangar;
    //     $hangars->name_en = $request->input('name_en');
    //     $hangars->name_ps = $request->input('name_ps');
    //     $hangars->name_prs = $request->input('name_prs');
    //     $hangars->description = $request->input('description');
        
    //     $hangars->save();
    //     // return response()->json([
    //     //     'status'=>200,
    //     //     'message'=>'hangars Added Successfully.'
    //     // ]);
    //     return response()->json(['success'=>'hangars saved successfully.']);

    // }
    $validator = Validator::make($request->all(), [
        'name_prs' => 'required',
     
    ]);
    if ($validator->fails()) {
        return response()->json([
            'status' => 400,
            'message' => __('general_words.missing_inputs_or_duplicate_number'),
            'errors' => $validator->messages()
        ]);
    }
        else {
            try {
                DB::beginTransaction();
                $hangar = $this->hangar->create([
                    'name_en' => $request->name_en,
                    'name_prs' => $request->name_prs,
                    'name_ps' => $request->name_ps,
                    'description' => $request->description,
                    'created_by' => auth()->user()->id
                ]);
                // insertFlow('fecen9_flows', 'fecen9_id', $fecen9->id);
                // insertLog('fecen9s', __('general_words.store'),  '/fc9/' . $fecen9->id, __('fc9.fc9'), $fecen9->id, $fecen9, null, $request);
                DB::commit();
                return response()->json([
                    'id' => $hangar->id,
                    'status' => 200,
                    'message' => __('general_words.record_saved'),
                ]);
            } catch (\Exception $e) {
                DB::rollBack();
                \Log::error($e);
                return response()->json([
                    'status' => 400,
                    'message' => __('general_words.something_went_wrong'),
                    'errors' => $e
                ]);
            }
    } 

}
public function edit($id)
{
    $data = $this->hangar->find($id);
    // $data->selected_dir = getRecordFromTable('directorates', $data->directorate_id);
    return $data;
    // $hangar = Hangar::find($id);
    // if($hangar)
    // {
    //     return response()->json([
    //         'status'=>200,
    //         'hangar'=> $hangar,
    //     ]);
    // }
    // else
    // {
    //     return response()->json([
    //         'status'=>404,
    //         'message'=>'No hangar Found.'
    //     ]);
    // }

}
public function update(Request $request, $id)
{
    // return $id;
    $validator = Validator::make($request->all(), [
        'name_prs' => 'required',
       
    ]);
    if ($validator->fails()) {
        return response()->json([
            'status' => 400,
            'message' => __('general_words.missing_inputs'),
            'errors' => $validator->messages()
        ]);
    } else {
        try {
            $details = Hangar::find($id);
            DB::beginTransaction();
            $update = $details->update([
                'name_en' => $request->name_en,
                'name_prs' => $request->name_prs,
                'name_ps' => $request->name_ps,
                'description' => $request->description,
                'updated_by' => auth()->user()->id
            ]);
            // insertLog('fecen9_details', __('general_words.update_item'),   '/fc9/' . $request->fecen9_id, __('fc9.fc9'), $details->fecen9_id, $update,$details, $request);
            DB::commit();
            return response()->json([
                'status' => 200,
                'hangar' => $this->hangar->find($id),
                'message' => __('general_words.record_updated'),
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error($e);
            return response()->json([
                'status' => 400,
                'message' => __('general_words.something_went_wrong'),
                'errors' => $e
            ]);
        }
   }
}
public function destroy($id)
{
    $hangars = Hangar::find($id);
    if($hangars)
    {
        $hangars->delete();
        return response()->json([
            'status'=>200,
            'message'=>'hangars Deleted Successfully.'
        ]);
    }
    else
    {
        return response()->json([
            'status'=>404,
            'message'=>'No hangars Found.'
        ]);
    }
}
}
