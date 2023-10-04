<?php

namespace App\Http\Controllers;

use DB;
use App\Models\UnitOfMeasure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MeasureController extends Controller
{

    protected $measure;
    public function __construct(UnitOfMeasure $measure)
    {
        $this->measure   = $measure;
    }
    public function index(Request $request){
        // $data['directorates'] = (new Directorate())->getDirectorate();
        if ($request->ajax()) {
            return $this->measure->measureList($request);
        }
        return view('settings.unit_of_measure.index');
    }
    public function store(Request $request){
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
                    $measures = $this->measure->create([
                        'name_en' => $request->name_en,
                        'name_prs' => $request->name_prs,
                        'name_ps' => $request->name_ps,
                        'created_by' => auth()->user()->id
                    ]);
                    // insertFlow('fecen9_flows', 'fecen9_id', $fecen9->id);
                    // insertLog('fecen9s', __('general_words.store'),  '/fc9/' . $fecen9->id, __('fc9.fc9'), $fecen9->id, $fecen9, null, $request);
                    DB::commit();
                    return response()->json([
                        'id' => $measures->id,
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
        $data = $this->measure->find($id);
        // $data->selected_dir = getRecordFromTable('directorates', $data->directorate_id);
        return $data;
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
            $details = UnitOfMeasure::find($id);
            DB::beginTransaction();
            $update = $details->update([
                'name_en' => $request->name_en,
                'name_prs' => $request->name_prs,
                'name_ps' => $request->name_ps,
                'updated_by' => auth()->user()->id
            ]);
            // insertLog('fecen9_details', __('general_words.update_item'),   '/fc9/' . $request->fecen9_id, __('fc9.fc9'), $details->fecen9_id, $update,$details, $request);
            DB::commit();
            return response()->json([
                'status' => 200,
                'measure' => $this->measure->find($id),
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
    $measure = UnitOfMeasure::find($id);
    if($measure)
    {
        $measure->delete();
        return response()->json([
            'status'=>200,
            'message'=>'measure Deleted Successfully.'
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
}
