<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class DepartmentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('departments')->insert([[
            
            'name_en' => 'Systems aerial department',
            'name_ps' => 'د سیستمونو هوایِي آمریت',
            'name_prs' => 'آمریت هوایی سیستم ها',
        ]
    ]);
    }
}
