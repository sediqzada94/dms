<?php

namespace App\Http\Controllers;

use DB;
use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
class VenderController extends Controller
{

    protected $vender;
    public function __construct(Vendor $vender)
    {
        $this->vender   = $vender;
    }
    public function index(Request $request){
        // $data['directorates'] = (new Directorate())->getDirectorate();
        if ($request->ajax()) {
            return $this->vender->vendorList($request);
        }
        return view('settings.venders.index');
    }

    public function store(Request $request)
    {
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
                    $venders = $this->vender->create([
                        'name_en' => $request->name_en,
                        'name_prs' => $request->name_prs,
                        'name_ps' => $request->name_ps,
                        'phone' => $request->phone,
                        'bank_account' => $request->bank_account,
                        'created_by' => auth()->user()->id
                    ]);
                    // insertFlow('fecen9_flows', 'fecen9_id', $fecen9->id);
                    // insertLog('fecen9s', __('general_words.store'),  '/fc9/' . $fecen9->id, __('fc9.fc9'), $fecen9->id, $fecen9, null, $request);
                    DB::commit();
                    return response()->json([
                        'id' => $venders->id,
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
        $data = $this->vender->find($id);
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
                $details = Vendor::find($id);
                DB::beginTransaction();
                $update = $details->update([
                    'name_en' => $request->name_en,
                    'name_prs' => $request->name_prs,
                    'name_ps' => $request->name_ps,
                    'phone' => $request->phone,
                    'bank_account' => $request->bank_account,
                    'updated_by' => auth()->user()->id
                ]);
                // insertLog('fecen9_details', __('general_words.update_item'),   '/fc9/' . $request->fecen9_id, __('fc9.fc9'), $details->fecen9_id, $update,$details, $request);
                DB::commit();
                return response()->json([
                    'status' => 200,
                    'vender' => $this->vender->find($id),
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
    $venders = Vendor::find($id);
    if($venders)
    {
        $venders->delete();
        return response()->json([
            'status'=>200,
            'message'=>'venders Deleted Successfully.'
        ]);
    }
    else
    {
        return response()->json([
            'status'=>404,
            'message'=>'No venders Found.'
        ]);
    }
}
}
