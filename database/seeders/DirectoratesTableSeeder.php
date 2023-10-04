<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class DirectoratesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('directorates')->insert([[
            
            'name_en' => 'Khazaen directorate',
            'name_ps' => 'د خزاینو ریاست',
            'name_prs' => 'ریاست خزاین',
            'parent_id' => '1',
        ],
        [
            
            'name_en' => 'ICT directorate',
            'name_ps' => 'معلوماتي ټکنالوژۍ ریاست',
            'name_prs' => 'ریاست تکنالوژی معلوماتی',
            'parent_id' => '2',
        ],
        [
            
            'name_en' => 'Human resource directorate',
            'name_ps' => 'بشري سرچینې ریاست',
            'name_prs' => 'ریاست منابع بشری',
            'parent_id' => '1',
        ]
    ]);
    }
    }

