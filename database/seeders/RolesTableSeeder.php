<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use App\Models\RolePermission;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;


class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // role table
        $check_role = (new Role())->where('slug', 'admin')->first();
        if (!$check_role) {
            $role = Role::create([
                'name_en' => 'admin',
                'name_ps' => 'ادمین',
                'name_prs' => 'ادمین',
                'slug' => 'admin'
            ]);
            foreach (Permission::all() as $key => $value) {
                $role->permissions()->attach($value, ['id' => Str::uuid()->toString()]);
            }
        }

//        Role for Services Director
        $check_role = (new Role())->where('slug', 'services-director')->first();
        if (!$check_role) {
        $p = Permission::whereNotIn('permissions.name', ['user_create', 'user_view', 'user_edit', 'user_list','user_delete','role_delete', 'role_create', 'role_view', 'role_edit', 'role_list'])
            ->get();
        $role = Role::create([
                'name_en' => 'Services Director',
                'name_prs' => 'رئیس خدمات',
                'name_ps' => 'خدمات رئیس',
                'slug' => 'services-director'
            ]);
            foreach ($p as $key => $value) {
                (new RolePermission())->create([
                    'id'=> Str::uuid()->toString(),
                    'role_id' => $role->id,
                    'permission_id' => $value->id
                ]);
            }
        }

//        Role for General Director
        $sharedPermission = Permission::where('permissions.name', 'like', '%' . 'fecen9' . '%')->get();
        $check_role = (new Role())->where('slug', 'general_director')->first();
        if (!$check_role) {
            $role = Role::create([
                'name_en' => 'General Director',
                'name_prs' => 'رئیس عمومی',
                'name_ps' => 'عمومی رئیس',
                'slug' => 'general-director'
            ]);
        foreach ($sharedPermission as $key => $value) {
            (new RolePermission())->create([
                'id'=> Str::uuid()->toString(),
                'role_id' => $role->id,
                'permission_id' => $value->id
            ]);
        }
        }
//
////        Role for Director
        $check_role = (new Role())->where('slug', 'director')->first();
        if (!$check_role) {
            $role = Role::create([
                'name_en' => 'Director',
                'name_ps' => 'ریس',
                'name_prs' => 'ریس',
                'slug' => 'director',
            ]);
            foreach ($sharedPermission as $key => $value) {
                (new RolePermission())->create([
                    'id'=> Str::uuid()->toString(),
                    'role_id' => $role->id,
                    'permission_id' => $value->id
                ]);
            }
        }

//        Role for Department Head
        $check_role = (new Role())->where('slug', 'department-head')->first();
        if (!$check_role) {
            $role = Role::create([
                'name_en' => 'Department Head',
                'name_ps' => 'آمر',
                'name_prs' => 'آمر',
                'slug' => 'department-head',
            ]);
            foreach ($sharedPermission as $key => $value) {
                (new RolePermission())->create([
                    'id'=> Str::uuid()->toString(),
                    'role_id' => $role->id,
                    'permission_id' => $value->id
                ]);
            }
        }

//        Role for Asset Management Head
        $check_role = (new Role())->where('slug', 'asset-management-head')->first();
        if (!$check_role) {
            $role = Role::create([
                'name_en' => 'Asset Management Head',
                'name_ps' => 'محاسبه جنسی آمر',
                'name_prs' => 'آمر محاسبه جنسی',
                'slug' => 'asset-management-head',
            ]);
            $permissions = Permission::where('permissions.name', 'like', '%' . 'fecen9' . '%')
                ->orWhere('permissions.name', 'like', '%' . 'fecen5' . '%')
                ->orWhere('permissions.name', 'like', '%' . 'meem7' . '%')->get();
            foreach ($permissions as $key => $value) {
                (new RolePermission())->create([
                    'id'=> Str::uuid()->toString(),
                    'role_id' => $role->id,
                    'permission_id' => $value->id
                ]);
            }
        }
//        Role for Asset Management General Manager
        $check_role = (new Role())->where('slug', 'asset-management-general-manager')->first();
        if (!$check_role) {
            $role = Role::create([
                'name_en' => 'Asset Management General Manager',
                'name_ps' => 'مدیریت عمومی محاسبه جنسی',
                'name_prs' => 'محاسبه جنسی عمومی مدیر',
                'slug' => 'asset-management-general-manager',
            ]);
            $permissions = Permission::whereIn('permissions.name', ['fecen9_list', 'meem7_list', 'fecen5_list'])->get();
            foreach ($permissions as $key => $value) {
                (new RolePermission())->create([
                    'id'=> Str::uuid()->toString(),
                    'role_id' => $role->id,
                    'permission_id' => $value->id
                ]);
            }
        }
//        Role for Items Registration Manager
        $check_role = (new Role())->where('slug', 'items-registration-manager')->first();
        if (!$check_role) {
            $role = Role::create([
                'name_en' => 'Items Registration Manager',
                'name_ps' => 'د اجناسو د ثبت مدیر',
                'name_prs' => 'مدیر ثبت اجناس',
                'slug' => 'items-registration-manager',
            ]);
            $permissions = Permission::where('permissions.name', 'like', '%' . 'fecen5' . '%')
                ->orWhere('permissions.name', 'like', '%' . 'card_to_card' . '%')
                ->orWhere('permissions.name', 'like', '%' . 'fecen8' . '%')->get();
            foreach ($permissions as $key => $value) {
                (new RolePermission())->create([
                    'id'=> Str::uuid()->toString(),
                    'role_id' => $role->id,
                    'permission_id' => $value->id
                ]);
            }
        }
////        Role for Items Registration Manager
        $check_role = (new Role())->where('slug', 'items-distribution-manager')->first();
        if (!$check_role) {
            $role = Role::create([
                'name_en' => 'Items Distribution Manager',
                'name_ps' => 'د اجناسو د توزیع مدیر',
                'name_prs' => 'مدیر توزیع اجناس ',
                'slug' => 'items-distribution-manager',
            ]);
            $permissions = Permission::where('permissions.name', 'like', '%' . 'fecen5' . '%')->get();
            foreach ($permissions as $key => $value) {
                (new RolePermission())->create([
                    'id'=> Str::uuid()->toString(),
                    'role_id' => $role->id,
                    'permission_id' => $value->id
                ]);
            }
        }
////       Role for Stock General Manager
        $check_role = (new Role())->where('slug', 'stock-general-manager')->first();
        if (!$check_role) {
            $role = Role::create([
                'name_en' => 'Stock General Manager',
                'name_ps' => 'د هنګر عمومی مدیر',
                'name_prs' => 'مدیر عمومی هنګر',
                'slug' => 'stock-general-manager',
            ]);
            $permissions = Permission::where('permissions.name', 'like', '%' . 'item_onhand' . '%')->get();
            foreach ($permissions as $key => $value) {
                (new RolePermission())->create([
                    'id'=> Str::uuid()->toString(),
                    'role_id' => $role->id,
                    'permission_id' => $value->id
                ]);
            }
        }
//
////       Role for IT Stock Manager
        $check_role = (new Role())->where('slug','it-stock-manager')->first();
        if (!$check_role) {
            $role = Role::create([
                'name_en' => 'IT Stock Manager',
                'name_ps' => 'د هنګر د تکنالوژی د بخش مدیر',
                'name_prs' => 'مدیر بخش تکنالوژی هنګر',
                'slug' => 'it-stock-manager',
            ]);
            $permissions = Permission::where('permissions.name', 'like', '%' . 'fecen9_list' . '%')->get();
            foreach ($permissions as $key => $value) {
                $role->permissions()->attach($value);
            }
        }
//
////       Role for Other Items Stock Manage
        $check_role = (new Role())->where('slug','other-items-stock-manager')->first();
        if (!$check_role) {
            $role = Role::create([
                'name_en' => 'Other Items Stock Manage',
                'name_ps' => 'د هنګر د نورو اجناسو مدیر',
                'name_prs' => 'مدیر بخش سایر اجناس هنګر',
                'slug' => 'other-items-stock-manager',
            ]);
            $permissions = Permission::whereIn('permissions.name',['fecen5_list','fecen9_list','meem7'])->get();;
            foreach ($permissions as $key => $value) {
                (new RolePermission())->create([
                    'id'=> Str::uuid()->toString(),
                    'role_id' => $role->id,
                    'permission_id' => $value->id
                ]);
            }
        }
//
////       Role for Other Items Stock Manage
        $check_role = (new Role())->where('slug','other-items-stock-manager')->first();
        if (!$check_role) {
            $role = Role::create([
                'name_en' => 'Other Items Stock Manage',
                'name_ps' => 'د هنګر د نورو اجناسو مدیر',
                'name_prs' => 'مدیر بخش سایر اجناس هنګر',
                'slug' => 'other-items-stock-manager',
            ]);
            $permissions = Permission::whereIn('permissions.name',['fecen5_list','fecen9_list','meem7'])->get();;
            foreach ($permissions as $key => $value) {
                (new RolePermission())->create([
                    'id'=> Str::uuid()->toString(),
                    'role_id' => $role->id,
                    'permission_id' => $value->id
                ]);
            }
        }
//
////       Role for Other Items Stock Manage
        $check_role = (new Role())->where('slug','storage-registration-manager')->first();
        if (!$check_role) {
            $role = Role::create([
                'name_en' => 'Storage Registration Manager',
                'name_ps' => 'د ثبت ذخیری مدیر',
                'name_prs' => 'مدیر ثبت ذخیره',
                'slug' => 'storage-registration-manager',
            ]);
            $permissions = Permission::where('permissions.name', 'like', '%' . 'meem7' . '%')
                                    ->orWhere('permissions.name', 'like', '%' . 'fecen1' . '%')
                                    ->orWhere('permissions.name', 'like', '%' . 'fecen4' . '%')->get()
            ;
            foreach ($permissions as $key => $value) {
                (new RolePermission())->create([
                    'id'=> Str::uuid()->toString(),
                    'role_id' => $role->id,
                    'permission_id' => $value->id
                ]);
            }
        }
////       Role for Storage Registration Employee
        $check_role = (new Role())->where('slug','storage-registration-employee')->first();
        if (!$check_role) {
            $role = Role::create([
                'name_en' => 'Storage Registration Employee',
                'name_ps' => 'د ثبت ذخیری مامور',
                'name_prs' => 'مامور ثبت ذخیره',
                'slug' => 'storage-registration-employee',
            ]);
            $permissions = Permission::where('permissions.name', 'like', '%' . 'meem7_list' . '%')->get();;
            foreach ($permissions as $key => $value) {
                (new RolePermission())->create([
                    'id'=> Str::uuid()->toString(),
                    'role_id' => $role->id,
                    'permission_id' => $value->id
                ]);
            }
        }

////       Role for Depreciation Items Storage Registration Employee
        $check_role = (new Role())->where('slug','depreciation-items-storage-registration-employee')->first();
        if (!$check_role) {
            $role = Role::create([
                'name_en' => 'Depreciation Items Storage Registration Employee',
                'name_ps' => 'د داغمه شوی اجناسو د ثبت ذخیری مامور',
                'name_prs' => 'مامور ثبت و ذخیره اجناس داغمه',
                'slug' => 'depreciation-items-storage-registration-employee',
            ]);
            $permissions = Permission::where('permissions.name',['fecen4_create','fecen4_list','meem7_list','meem7_create'])->get();;
            foreach ($permissions as $key => $value) {
                (new RolePermission())->create([
                    'id'=> Str::uuid()->toString(),
                    'role_id' => $role->id,
                    'permission_id' => $value->id
                ]);
            }
        }

////       Role for transport
        $check_role = (new Role())->where('slug','transport-management')->first();
        if (!$check_role) {
            $role = Role::create([
                'name_en' => 'Transport Management',
                'name_ps' => 'د ترانسپورت مدیریت',
                'name_prs' => 'مدیریت ترانسپورت',
                'slug' => 'transport-management',
            ]);
            $permissions = Permission::where('permissions.name', 'like', '%' . 'sejel' . '%')
                ->orWhere('permissions.name', 'like', '%' . 'moblin' . '%')
                ->orWhere('permissions.name', 'like', '%' . 'repairing' . '%')
                ->orWhere('permissions.name', 'meem7_list')
                ->orWhere('permissions.name', 'moblin_dashboard_widget')
                ->orWhere('permissions.name', 'repairing_dashboard_widget')
                ->orWhere('permissions.name', 'sejel_dashboard_widget')
                ->orWhere('permissions.name', 'oil_fc9_dashboard_widget')
                ->orWhere('permissions.name', 'like', '%' . 'oil'.'%')->get();
            foreach ($permissions as $key => $value) {
                (new RolePermission())->create([
                    'id'=> Str::uuid()->toString(),
                    'role_id' => $role->id,
                    'permission_id' => $value->id
                ]);
            }
        }
    }
}
