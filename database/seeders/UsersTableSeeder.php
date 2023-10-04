<?php
namespace Database\Seeders;
use App\Models\Role;
use App\Models\User;
use App\Models\UserRole;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role=(new Role())->where('slug','admin')->first();
        $department_head=(new Role())->where('slug','department-head')->first();
        $user=(new User())->where('name','admin')->first();

        if(!$user)
        {
            $user  = User::create([
                'name'     => 'admin',
                'email'    => 'admin@admin.com',
                'password' => bcrypt('mof@12345')
            ]);
            if($role && $user)
            {
                (new UserRole())->create([
                    'user_id' =>$user->id,
                    'role_id' => $role->id
                ]);
                (new UserRole())->create([
                    'user_id' =>$user->id,
                    'role_id' => $department_head->id
                ]);
            }
        }
    }
}
