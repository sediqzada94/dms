<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use illuminate\Support\Facades\DB;
class SubCategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('sub_categories')->insert([[
            'category_id' => '1',
            'name_en' => 'Information technolody',
            'name_ps' => 'معلوماتي ټکنالوژي',
            'name_prs' => 'تکنالوژی معلوماتی',
        ],
        [
            'category_id' => '1',
            'name_en' => 'Electrical equipment',
            'name_ps' => ' برقي وسایل ',
            'name_prs' => 'وسایل برقی',
        ],
        [
            'category_id' => '3',
            'name_en' => 'Furniture',
            'name_ps' => 'فرنیچر',
            'name_prs' => 'فرنیچر ',
        ]
    ]);
    }
}
