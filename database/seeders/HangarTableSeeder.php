<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class HangarTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('hangars')->insert([[
            'name_en' => 'هنگر ای تی ',
            'name_ps' => 'ای تی هنگر',
            'name_prs' => 'هنگر ای تی',
            'description' => 'هنگر ای تی',
            
        ],
        [
            'name_en' => 'Transport ',
            'name_ps' => 'ترانسپورت هنگر',
            'name_prs' => 'هنگر ترانسپورت',
            'description' => 'هنگر ترانسپورت',
            
        ],
        [
            'name_en' => 'هنگر عمومی',
            'name_ps' => 'عمومی هنگر',
            'name_prs' => 'هنگر عمومی',
            'description' => 'عمومی',
            
        ]
    ]);
    }
}
