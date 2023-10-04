<?php

namespace App\Http\Controllers;

use App\Models\CardToCard;
use App\Models\Directorate;
use App\Models\Employee;
use App\Models\EmployeeItemReceive;
use App\Models\EmployeeItemReturn;
use App\Models\Fecen5;
use App\Models\Fecen5ItemDetail;
use App\Models\Fecen8;
use App\Models\Fecen8Detail;
use App\Models\ItemSpec;
use App\Models\Meem7;
use App\Models\Stock;
use App\Models\Fecen4Detail;
use App\Models\Fecen9;
use App\Models\Item;
use App\Models\Vendor;
use App\Models\Motamed;
use App\Models\Log;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Arr;

class InventoryController extends Controller
{

    protected $fecen5;
    protected $fecen5_details;
    protected $item;
    protected $stock;
    protected $m7;
    protected $fc8;
    protected $card_to_card;
    protected $received;

    public function __construct(Fecen5 $fecen5, Fecen5ItemDetail $fecen5_details,
                                Item $item, Stock $stock,Meem7 $m7,Fecen8 $fc8,CardToCard $card_to_card,EmployeeItemReceive $received)
    {
        $this->fecen5         = $fecen5;
        $this->fecen5_details = $fecen5_details;
        $this->item           = $item;
        $this->stock          = $stock;
        $this->m7             = $m7;
        $this->fc8            = $fc8;
        $this->card_to_card   = $card_to_card;
        $this->received       = $received;
    }
    public function loggerTest(Request $request)
    {
        return $request;
    }
    public function checkingLog(Request $request)
    {
        return view('logs.create');
    }
    public function search(Request $request)
    {
        $type    = $request->type;
        $keyword = $request->keyword;
        if($type  =='item')
        {
            if($request->form_id){
                return (new Item())->getItems($keyword,'','','','',$request->form_name,$request->form_id);
            }
            else{
                return (new Item())->getItems($keyword);
            }
        }
        if($type =='form_items'){
            $form_name  = $request->form_name;
            $form_id    = $request->form_id;
            if($form_name=='meem7'){
                $items  = $this->m7->getMeem7Items($form_id,$keyword);
                return $items;
            }
        }
        if($type  =='employee')
        {
            return (new Employee())->getEmployee($keyword);
        }
        if($type  =='directorate')
        {
            return (new Directorate())->getDirectorate($keyword);
        }
        if($type  =='vendor')
        {
            return (new Vendor())->getVendor($keyword);
        }
        if($type  =='donor')
        {
            return (new Donor())->getDonor($keyword);
        }
    }
//    if some record not found from list this function will search it

    public function find(Request $request)
    {
        $table = $request->table;
        $id    = $request->id;
        if($table =='items')
        {
            return (new Item())->getItems(null,$id);
        }
        if($table =='employees')
        {
            return (new Employee())->getEmployee(null,$id);
        }
        if($table =='directorates')
        {
            return (new Directorate())->getDirectorate(null,$id);
        }
    }

//    check email or user name availability
    public function checkEmail(Request $request)
    {
        $result   = DB::table('users')->where('email',$request->email)->first();
        if ($result) {
            return 1;
        } else {
            return 0;
        }
    }
//    check if an item is duplicate
    public function checkDuplication(Request $request)
    {
        $table = $request->table_name;
        $foreign_key = $request->foreign_key;
        $foreign_key_id = $request->foreign_key_id;
        $check_id = $request->check_id;
        $check_id = $request->check_id;
        $employee_id = $request->employee_id;
        $result = DB::table($table)->where($foreign_key, $foreign_key_id)->where('item_id', $check_id)->first();
        if($employee_id){
            $result = DB::table($table)->where($foreign_key, $foreign_key_id)->where('item_id', $check_id)
                ->where($table.'.employee_id',$employee_id)
                ->first();
        }
        if ($result) {
            return 1;
        } else {
            return 0;
        }
    }
//    get records for v-select
    public function getData(Request $request)
    {
        $type= explode(',', $request->type);
        $response = [];
        if(in_array('items', $type)) {
            $response['items'] = (new Item())->getItems();
        }
        if(in_array('vehicle_items', $type)) {
            $response['items'] = (new Item())->getItems(slug:'vehicles');
        }
        // if(in_array('vehicle_part', $type)) {
        //     $response['items'] = (new Item())->getItems(slug:'vehicle-parts');
        // }
        if(in_array('vehicle-parts', $type)) {
            $items   = (new Item())->getItems(slug:'vehicle-parts');
            $item = $items->map(function ($item) {
                $specs      = (new ItemSpec)->getItemSpecs($item->id);
                $itemArr = [
                    'item_id'             => $item->id,
                    'measure_id'          => $item->measure_id,
                    'name'                => $item->name,
                    'measure'             => $item->measure,
                    'specs'               => $specs
                ];
                return $itemArr;
            });
            $response['items'] = $item;
        }
        if(in_array('oil', $type)) {
            $items   = (new Item())->getItems(slug:'oil');
            $item = $items->map(function ($item) {
                $specs      = (new ItemSpec)->getItemSpecs($item->id);
                $itemArr = [
                    'item_id'             => $item->id,
                    'measure_id'          => $item->measure_id,
                    'name'                => $item->name,
                    'measure'             => $item->measure,
                    'specs'               => $specs
                ];
                return $itemArr;
            });
            $response['items'] = $item;
        }
        if(in_array('categories', $type)) {
            $response['categories'] = getRecordFromTable('categories');
        }
        if(in_array('item_statuses', $type)) {
            $response['item_statuses'] = getRecordFromTable('item_statuses');
        }
        if(in_array('item_types', $type)) {
            $response['item_types'] = getRecordFromTable('item_types');
        }
        if(in_array('donors', $type)) {
            $response['donors'] = getRecordFromTable('donors');
        }
        if(in_array('hangars', $type)) {
            $response['hangars'] = getRecordFromTable('hangars');
        }
        if(in_array('unit_of_measures', $type)) {
            $response['unit_of_measures'] = getRecordFromTable('unit_of_measures');
        }
        if(in_array('motameds', $type)) {
            $response['motameds'] = DB::table('motameds')->get(['name','id']);
        }
        if(in_array('employees', $type)) {
            $response['employees'] = (new Employee())->getEmployee(null,null);;
        }
        if(in_array('directorates', $type)) {
            $response['directorates'] = (new Directorate())->getDirectorate();
        }
        if(in_array('fecen8', $type)) {
            $response['fecen8s'] = (new Fecen8())->get(['fecen8_number','id']);
        }
        return $response;
    }
// this function is for migrating directorates from local auth database
    public function getDirectoratesFromLocalHR() {
        $insertData = [];
        $avialableDirectorates = [];
        $isRecordModefied = false;
        $headers = ['Accept' => 'application/json'];
        $directorates = Http::get(env('CUSTOM_API_LOCAL_HR_BASE_URL') . 'api/inventory-system/get-directorates', $headers);
        $directorates = json_decode($directorates, true);
        $directorateModel = (new Directorate());
        $avialableDirectorates = $directorateModel::all();

        foreach($directorates as $directorate) {
            array_push($insertData, [
                'id' => $directorate['id'],
                'name_en' => $directorate['name_en'],
                'name_prs' => $directorate['name'],
                'name_ps' => $directorate['name_pa'],
                'parent_id' => $directorate['parent'],
               ]);
        }

        foreach($insertData as $key => $insertDir) {
            foreach($avialableDirectorates as $avialableDir) {
                    if ($avialableDir->id == $insertDir['id']) {
                        if ($avialableDir->name_en !== $insertDir['name_en']
                        || $avialableDir->name_prs !== $insertDir['name_prs']
                        || $avialableDir->name_ps !== $insertDir['name_ps']
                        || $avialableDir->parent_id !== $insertDir['parent_id']) {
                            $isRecordModefied = $directorateModel::where('id','=', $insertDir['id'])->update([
                                'name_en' => $insertDir['name_en'],
                                'name_prs' => $insertDir['name_prs'],
                                'name_ps' => $insertDir['name_ps'],
                                'parent_id' => $insertDir['parent_id'],
                            ]);
                        }
                        unset($insertData[$key]);
                        break;
                    }
            }
        }

        if ($insertData) {
            $isRecordModefied = $directorateModel::insert($insertData);
        }
        unset($insertData);
        if ($isRecordModefied === false) {
            return response()->json('Directorates are not modefied or inserted');
        }
        return response()->json('Directorates are modefied or inserted');
    }

    // this function is for migrating employees from local auth database
    public function getEmployeesFromLocalHR() {
        $insertData = [];
        $avialableEmployees = [];
        $isRecordModified = false;
        $headers = ['Accept' => 'application/json'];
        $employees = Http::get(env('CUSTOM_API_LOCAL_HR_BASE_URL') . 'api/inventory-system/get-employees', $headers)->throw();
        $employees = $employees->json();
        $employeeModel = new Employee();

        // Get the IDs of all existing employees
        $existingIds = $employeeModel->pluck('id')->toArray();

        // Split the employees into chunks of 3000 records for faster insertions
        $chunkedEmployees = array_chunk($employees, 3000);

        // Loop through each chunk of employees
        foreach ($chunkedEmployees as $chunk) {
                $insertData = [];

                // Loop through each employee in the chunk
                foreach ($chunk as $employee) {
                    // Check if the employee already exists in the database
                    if (in_array($employee['id'], $existingIds)) {
                        // Update the employee record
                        $employeeModel->where('id', $employee['id'])->update($employee);
                        $isRecordModified = true;
                    } else {
                        // Add the employee record to the insert data
                        $insertData[] = $employee;
                    }
                }

                // Insert any new employee records
                if (!empty($insertData)) {
                    $employeeModel->insert($insertData);
                    $isRecordModified = true;
                }
            }

            // Return a response based on whether any records were modified or inserted
            if ($isRecordModified) {
                return response()->json('Employees were modified or inserted');
            } else {
                return response()->json('Employees were not modified or inserted');
            }
        // $insertData = [];
        // $avialableEmployees = [];
        // $isRecordModefied = false;
        // $headers = ['Accept' => 'application/json'];
        // $employees = Http::get(env('CUSTOM_API_LOCAL_HR_BASE_URL') . 'api/inventory-system/get-employees', $headers);
        // $employees = json_decode($employees, true);
        // $employeeModel = (new Employee());
        // $existingRecords = DB::table('employees')->get();


        // foreach($employees as $key => $employee) {
        //     foreach($avialableEmployees as $avialableEmp) {
        //             if ($avialableEmp->id == $employee['id']) {
        //                 if ($avialableEmp->name != $employee['name']
        //                 || $avialableEmp->last_name != $employee['last_name']
        //                 || $avialableEmp->father_name != $employee['father_name']
        //                 || $avialableEmp->position != $employee['position']
        //                 || $avialableEmp->gender != $employee['gender']
        //                 || $avialableEmp->phone != $employee['phone']
        //                 || $avialableEmp->email != $employee['email']
        //                 || $avialableEmp->directorate_id != $employee['directorate_id'])
        //                  {
        //                     $isRecordModefied = $employeeModel::where('id','=', $employee['id'])
        //                     ->update([
        //                         'name' => $employee['name'],
        //                         'last_name' => $employee['last_name'],
        //                         'father_name' => $employee['father_name'],
        //                         'position' => $employee['position'],
        //                         'gender' => $employee['gender'],
        //                         'phone' => $employee['phone'],
        //                         'email' => $employee['email'],
        //                         'directorate_id' => $employee['directorate_id'],
        //                         'hire_status' => $employee['hire_status'],
        //                     ]);
        //                 }
        //                 unset($employees[$key]);
        //                 break;
        //             }
        //     }
        // }

        // if ($employees) {
        //     foreach(array_chunk($employees,3000) as $emp) {
        //         $isRecordModefied = $employeeModel::insert($emp);
        //     }
        // }
        // unset($employees);
        // if ($isRecordModefied === false) {
        //     return response()->json('Employees are not modefied or inserted');
        // }
        // return response()->json('Employees are modefied or inserted');
    }

    public function getEmployeeItemReceived(Request $request)
    {
        return (new EmployeeItemReceive())->getEmployeeItemReceived($request->employee_id);
    }
    // public function getStockItemSpec(Request $request)
    // {
    //     return (new Stock())->getStockItemSpec($request->item_id);
    // }
    public function getStockItem(Request $request)
    {
        return (new Fecen4Detail())->getStockItem($request->item_id);
    }
    /**
     * Update or insert the follow for specific table.
     *
     */
    public function flow(Request $request)
    {
        try{
        DB::beginTransaction();
        $user   = auth()->user()->id;
        $column = null;
        if($request->table=='card_to_card_flows')
        {
            $column = 'card_to_card_id';
        }
        else{
            $explodeColumn = explode('_', $request->table);
            $column  = $explodeColumn[0].'_id';
        }
        $insertFlow  = DB::table($request->table)->insert([
            $column           => $request->table_id,
            'status_slug'     => $request->flow,
            'date'            => Carbon::now(),
            'remark'          => $request->remark,
            'updated_by'      => $user,
            'created_by'      => $user
        ]);
        $latestFlow = DB::table($request->table)->orderBy('created_at','desc')->first();
            DB::commit();
            return response()->json([
                'status' => 200,
                'flow'   => $latestFlow->status_slug,
                'message'    => __('general_words.record_saved'),
            ]);
        }
        catch(\Exception $e){
            DB::rollBack();
            \Log::error($e);
            return response()->json([
                'status' => 400,
                'message'=> __('general_words.something_went_wrong'),
                'errors'=> $e
            ]);
        }
    }

    public function checkFlowPermission(Request $request)
    {
        $table = $request->table;
        $id     = $request->id;
        $explodeColumn = explode('_', $table);
        $column  = $explodeColumn[0].'_id';
        $check    = DB::table($table)->where($column,$id)->orderBy('created_at','desc')->first(['status_slug as flow']);
        return $check->flow;
    }

//    get employees by their directorate

    public function getEmployeesByDir(Request $request)
    {
        $employees    = Employee::where('directorate_id',$request->dir_id)->selectRaw('name,id, CONCAT(name,"-",father_name) AS full_name')->get();
        return $employees;
    }

    public  function ownershipCard(Request $request) {
        if($request->ajax()){
            return (new EmployeeItemReceive())->employeeItemReceives($request);
        }
        return view('ownership_card.index');
    }

    public  function ownershipCardPrint($id) {
        $data['employee']    = (new Employee())->employeeDetails($id);
        // dd($data['employee']);
        // $items        = (new EmployeeItemReceive())->employeeReceivedItems($detail->employee_id, $detail->parent_form_name, $detail->parent_form_id);
        $data['items']       = (new EmployeeItemReceive())->getEmployeeItemReceived($id);
    // dd($data['items']);
        return view('ownership_card.print',$data);
    }
   


    public  function storageCard(Request $request) {
        $data['categories'] = getRecordFromTable('categories');
        $data['items'] = getRecordFromTable('items');
        $data['motameds'] = (new Motamed())->getMotamed1();
        if($request->ajax()){
            return (new Stock())->storageCardList($request);
        }
        return view('storage_card.index', $data);
    }

    public  function storageCardPrint(Request $request) {
        $data['detail'] = (new Stock())->storageCardPrint($request);
        // return $data;
        return view('storage_card.print',$data);
    }


    public  function logs(Request $request) {
        $data['directorates'] = getRecordFromTable('directorates');
        $data['users']        = DB::table('users')->get(['name','id']);
        if($request->ajax()){
            return (new Log())->logs($request);
        }
        return view('logs.index',$data);
    }

//    This function get all items in specific form( meem7,fecen8 and..)
    public function getFormItems(Request $request)
    {
        $form_name  = $request->form_name;
        $form_id    = $request->form_id;
        $items      = [];
        if($form_name =='meem7')
        {
            $items  = $this->m7->getMeem7Items($form_id);
        }
        elseif($form_name =='fecen8')
        {
            $items  = $this->fc8->getFecen8Items($form_id);
        }
        return $items;
    }

//    This function return the details of an item
    public function getItemDetails(Request $request)
    {
        $form_name       = $request->form_name;
        $form_id         = $request->form_id;
        $item_id         = $request->item_id;
        $measure_id      = $request->measure_id;
        $items           = [];
        $specs           = (new Stock())->getItemSpecification($form_name,$form_id,$item_id,$measure_id);
        return ['specs'=>$specs];
    }

//    Return the specific item specifications

    public function getItemSpec(Request $request)
    {
        $item_id         = $request->item_id;
        $keyword         = $request->keyword;
        $specifications  = (new ItemSpec())->getItemSpecs($item_id,$keyword);
        return $specifications;
    }
//    Return the specific employee items specifications

    public function employeeItemSpecs(Request $request)
    {
        $item_id = $request->item_id;
        $keyword = $request->keyword;
        $emp_id = $request->employee_id;
        $form_name = $request->form_name;
        $form_id = $request->form_id;
        $specs           = $this->received->getItemSpecs($emp_id,$form_name,$form_id,$item_id);
        return $specs;
    }

    /**
     * return the list of selected form type based on an specific employee used in fecen8.
     */

    public function getFormTypeData(Request $request)
    {
        $form_name    = $request->form_name;
        $employee_id  = $request->employee_id;
        $data         = [];
        if($form_name =='card_to_card'){
            $data = $this->card_to_card->getEmployeeCardToCards($employee_id);
        }
        elseif($form_name =='fecen5'){
            $data = $this->fecen5->getEmployeeFecen5s($employee_id);
        }

        return $data;
    }

    /**
     * return the list of selected form type items based on an specific employee used in fecen8.
     */
    public function getEmployeeFormItems(Request $request){
        $employee_id  = $request->employee_id;
        $form_id      = $request->form_id;
        $form_name    = $request->form_name;
        $items        =  $this->received->employeeReceivedItems($employee_id,$form_name,$form_id);
        return $items;
    }

    /**
     * return the items based on an specific fecen8 used in fecen1.
     */
    public function getFecen8Items(Request $request){
        $fecen8_id    = $request->fecen8_id;
        $items        =  (new Fecen8Detail())->getFecen8Items($fecen8_id);
        return $items;
    }
    /**
     * return the specs based on an selected item used in fecen1.
     */
    public function getFecen8ItemSpecs(Request $request){
        $fecen8_id    = $request->fecen8_id;
        $item_id      = $request->item_id;
        $items        =  (new Fecen8Detail())->getFecen8ItemSpecs($fecen8_id,$item_id);
        return $items;
    }



}
