<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class VendorsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('vendors')->insert([[
            'name_en' => 'xyz company',
            'name_ps' => 'شرکت XYZ',
            'name_prs' => 'XYZ شرکت',
            'email' => 'xyz@gmail.com',
            'phone' => '078822222',
        ],
        [
            'name_en' => 'Afghan Internatioanl',
            'name_ps' => 'افغان انترنشنل',
            'name_prs' => 'افغان انترنشنل',
            'email' => 'xyz@gmail.com',
            'phone' => '078822222',
        ],
        [
            'name_en' => 'Kabul Dubai',
            'name_ps' => 'کابل دوبی',
            'name_prs' => 'کابل دوبی',
            'email' => 'xyz@gmail.com',
            'phone' => '078822222',
        ]
    ]);
    }
}
