<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\DB;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;
use App\Traits\Uuids;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;
    use Uuids;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'status',
        'position_id',
        'employee_id',
        'directorate_id'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'profile_photo_url',
    ];
    public function roles()
    {
        return $this->belongsToMany('App\Models\Role', 'user_roles', 'user_id', 'role_id');
    }

    public function userDetail($id = 0)
    {
        if ($id) {
            return $this->leftjoin('user_roles', 'user_roles.user_id', 'users.id')
                ->leftjoin('roles', 'roles.id', 'user_roles.role_id')
                ->selectRaw('users.*,
            GROUP_CONCAT(roles.id) AS role_id,
            GROUP_CONCAT(roles.name_'.lang().') AS role')
                ->where('users.id', $id)
                ->first();
        }
    }
    public function users($request){
        $filter           = $request->input('search_keyword');
        $per_page         = $request->input('per_page') ? $request->input('per_page') : 10;
        $start_page       = $request->input('current_page');
        $order_by         = $request->input('order_by');
        $order_direction  = $request->input('order_direction');
        $name             = $request->name;
        $email            = $request->email;
        $query = DB::table('users')
            ->selectRaw('users.*,
        IF(users.status = 1, "' . __('general_words.active') . '", "' . __('general_words.deactivate') . '") as status
            ');
        if ($order_direction != '' || $order_by != '') {
            $query = $query->orderBy($order_by, $order_direction);
        }
        if ($filter != '') {
            $query = $query
                ->where('users.name', 'like', '%' . $filter . '%')
                ->orwhere('users.email', 'like', '%' . $filter . '%');
        }
        if ($name != 'null') {
            $query = $query->where('users.name', 'like', '%' . $name . '%');
        }
        if ($email != 'null') {
            $query = $query->where('users.email', 'like', '%' . $email . '%');
        }
        Paginator::currentPageResolver(function () use ($start_page) {
            return $start_page;
        });

        return $query->paginate($per_page);
    }
    public function userPermissionsCheck($userid, $permissions = array(), $booleanResult = true)
    {
        $flag = true;
        $has_all = false;
        $intersected_permission = array();

        if (is_array($permissions)) {
            if (count($permissions)) {
                $user = auth()->user();

                $checkPermissionCount = $this->getUserPermission($user->id, $permissions);

                if (count($checkPermissionCount)) {

                    foreach ($checkPermissionCount as $uperm) {
                        array_push($intersected_permission, $uperm->name);
                    }
                    if (count($checkPermissionCount) == count($permissions)) {
                        $flag = true;
                        $has_all = true;
                    } else {
                        $flag = true;
                        $has_all = false;
                    }
                } else {
                    $flag = false;
                    $has_all = false;
                }
                // check if

            }
        }

        if ($booleanResult) {
            return $flag;
        }

        return [
            'flag' => $flag,
            'has_all' => $has_all,
            'permissions' => $intersected_permission
        ];
    }
    // get user permission
    public function getUserPermission($userId, $permissions = array())
    {
        $query = $this->join('user_roles', 'user_roles.user_id', 'users.id')
            ->join('roles', 'roles.id', 'user_roles.role_id')
            ->leftjoin('role_permissions', 'role_permissions.role_id', 'roles.id')
            ->leftjoin('permissions', 'permissions.id', 'role_permissions.permission_id')
            ->selectRaw("permissions.name")
            ->where('users.id', $userId);
        if (count($permissions)) {
            $query = $query->whereIn('permissions.name', $permissions);
        }

        return $query->get();
    }}
