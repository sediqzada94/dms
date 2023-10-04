<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class DonorsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('donors')->insert([[
            
            'name_en' => 'Ministry of finance',
            'name_ps' => 'د مالیي وزارت',
            'name_prs' => ' وزارت مالیه',
        ],
        [
            
            'name_en' => 'Ministry of Foreign Affairs ',
            'name_ps' => 'د بهرنیو چارو وزارت',
            'name_prs' => 'وزارت امور خارجه',
        ],
        [
            
            'name_en' => 'Reyasat ul wazara ',
            'name_ps' => 'ریاست الوزراء',
            'name_prs' => 'ریاست الوزراء',
        ]
        
    ]);
    }
}
