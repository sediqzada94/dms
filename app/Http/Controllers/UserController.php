<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Position;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\UserRole;
use App\Models\Role;
use App\Models\UserPermission;
use App\Models\Permission;
use Illuminate\Support\Facades\Validator;
use App\Models\Item;
use App\Models\PermissionGroup;
use App\Models\RolePermission;
use Illuminate\Support\Str;

class UserController extends Controller
{
    protected $user;

    /**
     * __construct function initialize class
     *
     * @param User $user
     */
    public function __construct(User $user,
                                UserRole $userRole)
    {
        $this->user = $user;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // dd((new Item())->getItems());
        $data['directorates'] = getRecordFromTable('directorates');
        if ($request->ajax()) {
            return $this->user->users($request);
        }
        return view('user_management.users.index',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $p = Permission::whereNotIn('permissions.name', ['user_create', 'user_view', 'user_edit', 'user_list','user_delete','role_delete', 'role_create', 'role_view', 'role_edit', 'role_list'])->get();
        $roles      = getRecordFromTable('roles');
        $positions  = getRecordFromTable('positions');
        $employees  = (new Employee())->getEmployee();
        $permission_data = \App\Http\Controllers\RoleController::permissions();
        return view('user_management.users.create', [
            'roles'            => json_encode($roles),
            'permission_data'  => json_encode($permission_data),
            'positions'        => json_encode($positions),
            'employees'        => json_encode($employees)
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // return $request;
        $role_id = $request->get('role_id');
        // if (!is_array($role_id)) {
        //     $role_id = [$role_id];
        // }

        // if (isset($role_id[0])) {
        //     if (is_string($role_id[0])) {
        //         $role_id = explode(',', $role_id[0]);
        //     }
        // }
//        try {
            $employee   = (new Employee())->find($request->employee_id);
            DB::beginTransaction();
            $storeUser  = $this->user->create([
                'id'=>Str::uuid()->toString(),
                'name' => $request->get('name'),
                'email' => $request->get('email'),
                'password' => bcrypt($request->get('password')),
                'position_id' => $request->position,
                'employee_id' => $request->employee_id,
                'directorate_id' => $employee->directorate_id,
                'created_by' => auth()->user()->id,
            ]);
            if($storeUser){
            foreach ($role_id as $key => $value) {
                (new UserRole())->create([
                    'id'=> Str::uuid()->toString(),
                    'role_id' => $value,
                    'user_id' => $storeUser->id
                ]);
            }
            DB::commit();
                return response()->json([
                'status' => 200,
                'message' => __('general_words.record_saved')
            ]);

            }
//            DB::commit();
//            updateCreatedByOrUpdatedBy('users','created_by');
//            return response()->json([
//                'status' => 200,
//                'message' => __('general_words.record_saved')
//            ]);
//        } catch (\Exception $e) {
//            DB::rollBack();
//            return response()->json([
//                'status' => 400,
//                'message' =>  __('general_words.something_went_wrong')
//            ]);
//        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id = 0)
    {
        if ($id) {

            $user = $this->user->userDetail($id);
            $user->selected_employee = (new Employee())->getEmployee(null,$user->employee_id);
            $p = Permission::whereNotIn('permissions.name', ['user_create', 'user_view', 'user_edit', 'user_list','user_delete','role_delete', 'role_create', 'role_view', 'role_edit', 'role_list'])->get();

//             $permission_data = $this->permissions($id);
//             $permission_data = \App\Http\Controllers\UserController::permissions();
            $permission_data = \App\Http\Controllers\RoleController::permissions();
            $roleId = explode(',', $user->role_id);
            $userRole = (new Role())->whereIn('id', $roleId)->selectRaw('roles.name_'.lang().' as name,roles.id')->get();

            $roles      = getRecordFromTable('roles');
            $positions  = getRecordFromTable('positions');
            $employees  = (new Employee())->getEmployee();
//            dd($userRole);
            return view('user_management.users.edit', [
                'user' => ($user),
                'roles'            => json_encode($roles),
                'userRole' => json_encode($userRole),
                'employees'        => json_encode($employees),
                'positions'        => json_encode($positions),
                 'permission_data' => $permission_data,
            ]);
        }

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
public function changePassword(Request $request)
{
    // dd($request);
    $validator = Validator::make($request->all(), [
        'email'=> 'required|max:191',
        'password'=>'required|max:191',
        
     
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
    $user   = Auth()->user();
    // return $user;
    $password = $request->get('password');
    if ($password) {
        $password = bcrypt($password);
    }
    $storeUser  = $user->update([
        'email' => $request->get('email'),
        'password' => $password,
        'updated_by' => auth()->user()->id,
    ]);
    return ['status' => 200, 'message' => __('general_words.record_updated')];
}
}
    public function update(Request $request, $id)
    {
//        dd($request->all());

        //end: for log system
        if ($id) {
            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'email' => 'required|unique:users,email,' . $id . '|regex:/^\S*$/u',
                'role_ids' => 'required',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 400,
                    'message' => __('general_words.missing_inputs'),
                    'errors' => $validator->messages()
                ]);
            }

            // if ($request->get('password') != '' || $request->get('confirm_password')) {
            //     $this->validate($request, [
            //         'password' => 'required|min:4|max:8',
            //         'confirm_password' => 'required|same:password',
            //     ]);
            // }
            $role_ids = $request->get('role_ids');
            try {
                $user = $this->user->find($id);
                DB::beginTransaction();
                $password = $request->get('password');
                if ($password) {
                    $password = bcrypt($password);
                }
                $employee   = (new Employee())->find($request->employee_id);
                $storeUser  = $user->update([
                    'name' => $request->get('name'),
                    'email' => $request->get('email'),
                    'password' => $password,
                    'position_id' => $request->position,
                    'employee_id' => $request->employee_id,
                    'directorate_id' => $employee->directorate_id,
                    'updated_by' => auth()->user()->id,
                ]);
                (new UserRole())->where('user_id', $id)->delete();
                foreach ($role_ids as $key => $value) {
                    (new UserRole())->create([
                        'id'=> Str::uuid()->toString(),
                        'role_id' => $value,
                        'user_id' => $id
                    ]);
                }
                DB::commit();
                return ['status' => 200, 'message' => __('general_words.record_updated')];
            } catch (\Exception $e) {
                DB::rollBack();
                return response()->json(['message' => __('general_words.something_went_wrong')], 422);
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function deactivate($id)
    {
        try {
            DB::beginTransaction();
            $user = $this->user->where('id', $id)->first();
           $user->update([
               'status' => 0,
           ]);

            DB::commit();
            return response()->json([
                'status' => 200,
                'message' => __('general_words.record_updated')
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => 400,
                'message' =>  __('general_words.something_went_wrong')
            ]);
        }
    }
}
