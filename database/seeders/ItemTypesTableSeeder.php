<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class ItemTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('item_types')->insert([[
            
            'name_en' => 'Consuming',
            'name_ps' => 'مصرفي',
            'name_prs' => ' مصرفی',
            'slug' => 'consuming',
        ],
        [
            
            'name_en' => 'Depreciable',
            'name_ps' => 'استهلاکي',
            'name_prs' => 'استهلاکی',
            'slug' => 'depreciable',
        ],
        [
            
            'name_en' => 'Consuming After Document',
            'name_ps' => 'مصرفی بعد از ارایه سند',
            'name_prs' => 'مصرفی بعد از ارایه سند',
            'slug' => 'consuming-after-document',
        ]
    ]);
    }
}
