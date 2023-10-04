<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class ItemStatusesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('item_statuses')->insert([[   
            'name_en' => 'New',
            'name_ps' => 'نوی',
            'name_prs' => 'جدید',
            'slug' => 'new',
        ],
        [   
            'name_en' => 'Used',
            'name_ps' => 'مستعمل',
            'name_prs' => 'مستعمل',
            'slug' => 'used',
        ],
        [   
            'name_en' => 'داغمه',
            'name_ps' => 'داغمه',
            'name_prs' => 'داغمه',
            'slug' => 'daghma',
        ]
    ]);
    }
}
