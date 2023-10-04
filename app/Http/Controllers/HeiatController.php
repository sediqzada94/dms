<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Heiat;
use App\Models\Directorate;
use App\Models\Employee;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class HeiatController extends Controller
{
    //
    protected $heiat;
    public function __construct(Heiat $heiat)
    {
        $this->heiat   = $heiat;
    }
    public function index(Request $request)
    {
        $data['employees'] = (new Employee())->getEmployee();
        $data['directorates'] = (new Directorate())->getDirectorate();
        if ($request->ajax()) {
            return $this->heiat->HeiatList($request);
        }
        return view('settings.heiat.index', $data);
    }

    public function store(Request $request)
    {
        // dd($request);
        $validator = Validator::make($request->all(), [
            'start_date' => 'required',
            'end_date' => 'required',
           
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
                $heiat = new Heiat;
                // dd($heiat);
                $heiat->start_date = $request->input('start_date');
                $heiat->end_date = $request->input('end_date');
                $heiat->employee_id = $request->input('employee_id');
                $heiat->name = $employee->name;
                $heiat->last_name = $employee->last_name;
                $heiat->father_name = $employee->father_name;
                $heiat->position = $employee->position;
                $heiat->gender = $employee->gender;
                $heiat->phone = $employee->phone;
                $heiat->email = $employee->email;
                $heiat->directorate_id = $employee->directorate_id;
                $heiat->department = $employee->department;
                $heiat->hire_status = $employee->hire_status;
                $heiat->save();
                // return response()->json(['success'=>'heiat saved successfully.']);

                DB::commit();
                return response()->json([
                    'id' => $heiat->id,
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
    $data = $this->heiat
    ->selectRaw('id,CONCAT(name,"-",father_name) AS full_name,
            father_name,position,name, last_name, start_date, end_date')
    ->where('id', $id)->first();
    //$data->selected_employee = getRecordFromTable('employees', $data->employee_id);
    return $data;
}
public function update(Request $request, $id)
{
    $validator = Validator::make($request->all(), [
        'start_date' => 'required',
       
       
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
                $heiat = Heiat::find($id);
                DB::beginTransaction();
        $employee = (new Employee())->where('id', '=', $request->input('employee_id'))->first();
        if($heiat)
        {
            $heiat->start_date = $request->input('start_date');
            $heiat->end_date = $request->input('end_date');
            $heiat->employee_id = $request->input('employee_id');
            $heiat->name = $employee->name;
            $heiat->last_name = $employee->last_name;
            $heiat->father_name = $employee->father_name;
            $heiat->position = $employee->position;
            $heiat->gender = $employee->gender;
            $heiat->phone = $employee->phone;
            $heiat->email = $employee->email;
            $heiat->directorate_id = $employee->directorate_id;
            $heiat->department = $employee->department;
            $heiat->hire_status = $employee->hire_status;

            $heiat->update();
            DB::commit();
            return response()->json([
                'status'=>200,
                'heiat' => $this->heiat->find($id),
                'message' => __('general_words.record_updated'),
            ]);
        }
     }
      catch (\Exception $e) {
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
    $heiat = Heiat::find($id);
    if($heiat)
    {
        $heiat->delete();
        return response()->json([
            'status'=>200,
            'message'=>'heiat Deleted Successfully.'
        ]);
    }
    else
    {
        return response()->json([
            'status'=>404,
            'message'=>'No heiat Found.'
        ]);
    }
}
}
