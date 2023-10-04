<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class EmployeesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('employees')->insert([
            [
            'id' => '1',
            'name' => 'سمیع الله ',
            'last_name' => 'صدیق زاده',
            'father_name' => ' شفیق الله',
            'position' => 'کارشناس ارشد تحلیل سیستم ها',
            'directorate_id' => 1,
            'department' => ' آمریت تحلیل سیستم ها',
            'hire_status' => '1',
            ],
            [
            'id' => '2',
            'name' => 'وحید الله ',
            'last_name' => ' ستانکزی ',
            'father_name' => 'شیرآغا',
            'position' => 'آمر ارشد تحلیل سیستم ها',
            'directorate_id' => 2,
            'department' => ' آمریت تحلیل سیستم ها',
            'hire_status' => '1',
            ],
            [
            'id' => '3',
            'name' => 'نعیم الله ',
            'lastـname' => ' نعیم ',
            'father_name' => 'روح الله',
            'position' => 'آمر ارشد تحلیل سیستم ها',
            'directorate_id' => 1,
            'department' => ' آمریت تحلیل سیستم ها',
            'hire_status' => '1',
            ],
            [
            'id' => '4',
            'name' => 'عباد الله ',
            'last_name' => ' میوند ',
            'father_name' => 'حاجی صاحب',
            'position' => 'آمر ارشد تحلیل سیستم ها',
            'directorate_id' => 2,
            'department' => ' آمریت تحلیل سیستم ها',
            'hire_status' => '1',
        ]
    ]);
    }
}
