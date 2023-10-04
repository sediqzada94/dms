<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class MotamedsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('motameds')->insert([
            [
            'hangar_id' => '1',
            'employee_id' => '1',
            'name' => 'سمیع الله ',
            'last_name' => 'صدیق زاده',
            'father_name' => ' شفیق الله',
            'position' => 'کارشناس ارشد تحلیل سیستم ها',
            'directorate_id' => 1,
            'department' => ' آمریت تحلیل سیستم ها',
            'hire_status' => '1',
            ],
            [
            'hangar_id' => '2',
            'employee_id' => '3',
            'name' => 'نعیم الله ',
            'last_name' => ' نعیم ',
            'father_name' => 'روح الله',
            'position' => 'آمر ارشد تحلیل سیستم ها',
            'directorate_id' => 2,
            'department' => ' آمریت تحلیل سیستم ها',
            'hire_status' => '1',
            ]
    ]);


    DB::table('heiat_tashrih')->insert([
        [
        'start_date' => '2023-03-22',
        'end_date' => '2023-04-22',
        'employee_id' => '3',
        'name' => 'نعیم الله ',
        'last_name' => ' نعیم ',
        'father_name' => 'روح الله',
        'position' => 'آمر ارشد تحلیل سیستم ها',
        'directorate_id' => 2,
        'department' => ' آمریت تحلیل سیستم ها',
        'hire_status' => '1',
        ]
]);
    }
}
