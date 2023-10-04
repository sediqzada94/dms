<?php

namespace App\Http\Controllers;

use DB;
use App\Models\Item;
use App\Models\Motamed;
use App\Models\Employee;
use App\Models\Hangar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MotamedController extends Controller
{
    protected $motamed;
    public function __construct(Motamed $motamed)
    {
        $this->motamed   = $motamed;
    }
    public function index(Request $request)
    {
        $data['employees'] = (new Employee())->getEmployee();
        // $data['hangar'] = (new Hangar())->hangarList();
        $data['hangar']=getRecordFromTable('hangars');
        if ($request->ajax()) {
            return $this->motamed->motamedList($request);
        }
        return view('settings.motamed.index', $data);
    }
    public function fetchmotamed()
    {
    
    $motamed = Motamed::with(['hangar', 'employee'])->get();
    return response()->json([
        'motamed'=>$motamed,
    ]);
    }
public function store(Request $request)

{
  
    $validator = Validator::make($request->all(), [
        'hangar_id'=> 'required|max:191',
        'employee_id'=> 'required|max:191',
       
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
            $employee = (new Employee())->where('id', '=', $request->input('employee_id'))->first();
            $motamed = new Motamed;
            $motamed->hangar_id = $request->input('hangar_id');
            $motamed->employee_id = $request->input('employee_id');
            $motamed->name = $employee->name;
            $motamed->last_name = $employee->last_name;
            $motamed->father_name = $employee->father_name;
            $motamed->position = $employee->position;
            $motamed->gender = $employee->gender;
            $motamed->phone = $employee->phone;
            $motamed->email = $employee->email;
            $motamed->directorate_id = $employee->directorate_id;
            $motamed->department = $employee->department;
            $motamed->hire_status = $employee->hire_status;
            $motamed->save();
//         return response()->json(['success'=>'motamed saved successfully.']);
            // return response()->json(['success'=>'heiat saved successfully.']);

            DB::commit();
            return response()->json([
                'id' => $motamed->id,
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
    $data = $this->motamed
    ->selectRaw('id,CONCAT(name,"-",father_name) AS full_name,
            father_name,position,name, last_name, hangar_id')
    ->where('id', $id)->first();
    //$data->selected_employee = getRecordFromTable('employees', $data->employee_id);
    return $data;
    // $motamed = Motamed::where('motameds.id',$id)
    // ->join('hangars','hangar_id','hangars.id')
    //     ->join('employees','employee_id','employees.id')
       
    //     ->select('motameds.*','hangars.name_en as hangars_name','employees.name as employee_name')
    //     ->get();
    //  if($motamed)
    // {
    //     return response()->json([
    //         'status'=>200,
    //         'motamed'=> $motamed,
    //     ]);
    // }
    // else
    // {
    //     return response()->json([
    //         'status'=>404,
    //         'message'=>'No motamed Found.'
    //     ]);
    // }

}
public function update(Request $request, $id)
{
    $validator = Validator::make($request->all(), [
        'hangar_id'=> 'required|max:191',
        'employee_id'=> 'required|max:191',
    
        
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
        $motamed = Motamed::find($id);
        $employee = (new Employee())->where('id', '=', $request->input('employee_id'))->first();
        if($motamed)
        {
            $motamed->hangar_id = $request->input('hangar_id');
            $motamed->employee_id = $request->input('employee_id');
            $motamed->name = $employee->name;
            $motamed->last_name = $employee->last_name;
            $motamed->father_name = $employee->father_name;
            $motamed->position = $employee->position;
            $motamed->gender = $employee->gender;
            $motamed->phone = $employee->phone;
            $motamed->email = $employee->email;
            $motamed->directorate_id = $employee->directorate_id;
            $motamed->department = $employee->department;
            $motamed->hire_status = $employee->hire_status;

            $motamed->update();
            return response()->json([
                'status'=>200,
                'message'=>'motamed Updated Successfully.'
            ]);
        }
        else
        {
            return response()->json([
                'status'=>404,
                'message'=>'No motamed Found.'
            ]);
        }

    }
}
public function destroy($id)
{
    $motamed = Motamed::find($id);
    if($motamed)
    {
        $motamed->delete();
        return response()->json([
            'status'=>200,
            'message'=>'motamed Deleted Successfully.'
        ]);
    }
    else
    {
        return response()->json([
            'status'=>404,
            'message'=>'No motamed Found.'
        ]);
    }
}
}
