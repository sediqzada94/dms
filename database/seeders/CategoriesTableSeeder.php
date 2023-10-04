<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('categories')->insert([
        [
            'name_prs'=>'کتاب ها',
            'name_ps'=>'کتاب ها',
            'name_en'=>'کتاب ها',
            'slug'=>'books',
        ],
        [
            'name_prs'=>'لوازم تکنالوژی',
            'name_ps'=>'لوازم تکنالوژی',
            'name_en'=>'لوازم تکنالوژی',
            'slug'=>'it-equipment',
        ],
        [
            'name_prs'=>'پرزه جات وسایط',
            'name_ps'=>'وسایطو پرزې',
            'name_en'=>'وسایطو پرزې',
            'slug'=>'vehicle-parts',
        ],
        [
            'name_prs'=>'تعمیرات',
            'name_ps'=>'تعمیرات',
            'name_en'=>'تعمیرات',
            'slug'=>'constructions',
        ],
        [
            'name_prs'=>'متفرقه',
            'name_ps'=>'متفرقه',
            'name_en'=>'متفرقه',
            'slug'=>'miscellaneous',
        ],
        [
            'name_prs'=>'لوازم برقی',
            'name_ps'=>'لوازم برقی',
            'name_en'=>'لوازم برقی',
            'slug'=>'electronic-equipment',
        ],
        [
            'name_prs'=>'ادویه جات و لوازم طبی',
            'name_ps'=>'ادویه جات و لوازم طبی',
            'name_en'=>'ادویه جات و لوازم طبی',
            'slug'=>'drugs-and-medical-equipment',
        ],
        [
            'name_prs'=>'کمپیوتر- پرنتر-UPS و هاردسک',
            'name_ps'=>'کمپیوتر- پرنتر-UPS و هاردسک',
            'name_en'=>'کمپیوتر- پرنتر-UPS و هاردسک',
            'slug'=>'harddesk-ups-computer-printer',
        ],
        [
            'name_prs'=>'ظروف',
            'name_ps'=>'ظروف',
            'name_en'=>'ظروف',
            'slug'=>'dishes',
        ],
        [
            'name_prs'=>'وسایل نجاری',
            'name_ps'=>'وسایل نجاری',
            'name_en'=>'وسایل نجاری',
            'slug'=>'carpentry-equipment',
        ],
        [
            'name_prs'=>'قرطاسیه',
            'name_ps'=>'قرطاسیه',
            'name_en'=>'قرطاسیه',
            'slug'=>'stationery',
        ],
        [
            'name_prs'=>'وسایل نلدوانی',
            'name_ps'=>'وسایل نلدوانی',
            'name_en'=>'وسایل نلدوانی',
            'slug'=>'',
        ],
        [
            'name_prs'=>'مبل، الماری، میز و چوکی',
            'name_ps'=>'مبل، الماری، میز و چوکی',
            'name_en'=>'مبل، الماری، میز و چوکی',
            'slug'=>'',
        ],
        [
            'name_prs'=>'روغنیات وسایط',
            'name_ps'=>'روغنیات وسایط',
            'name_en'=>'روغنیات وسایط',
            'slug'=>'oil',
        ],
        [
            'name_prs'=>'بطری وسایط و جنراتور',
            'name_ps'=>'بطری وسایط و جنراتور',
            'name_en'=>'بطری وسایط و جنراتور',
            'slug'=>'',
        ],
        [
            'name_prs'=>'البسه',
            'name_ps'=>'البسه',
            'name_en'=>'البسه',
            'slug'=>'',
        ],
        [
            'name_prs'=>'لوازم تنظیفی',
            'name_ps'=>'لوازم تنظیفی',
            'name_en'=>'لوازم تنظیفی',
            'slug'=>'',
        ],
        [
            'name_prs'=>'تایر مختلف النوع',
            'name_ps'=>'تایر مختلف النوع',
            'name_en'=>'تایر مختلف النوع',
            'slug'=>'vehicle-parts',
        ],
        [
            'name_prs'=>'مفروشات',
            'name_ps'=>'مفروشات',
            'name_en'=>'مفروشات',
            'slug'=>'',
        ],
        [
            'name_prs'=>'فورمه جات و مواهیر',
            'name_ps'=>'فورمه جات و مواهیر',
            'name_en'=>'فورمه جات و مواهیر',
            'slug'=>'',
        ],
        [
            'name_prs'=>'وسایل رنگمالی',
            'name_ps'=>'وسایل رنگمالی',
            'name_en'=>'وسایل رنگمالی',
            'slug'=>'',
        ],
        [
            'name_prs'=>'تیل دیزل و پطرول',
            'name_ps'=>'تیل دیزل و پطرول',
            'name_en'=>'تیل دیزل و پطرول',
            'slug'=>'oil',
        ],
        [
            'name_prs'=>'محروقات',
            'name_ps'=>'محروقات',
            'name_en'=>'محروقات',
            'slug'=>'',
        ],
        [
            'name_prs'=>'فلتر باب',
            'name_ps'=>'فلتر باب',
            'name_en'=>'فلتر باب',
            'slug'=>'',
        ],
        [
            'name_prs'=>'کارتریج و تونر',
            'name_ps'=>'کارتریج و تونر',
            'name_en'=>'کارتریج و تونر',
            'slug'=>'',
        ],
        [
            'name_prs'=>'اجرت',
            'name_ps'=>'اجرت',
            'name_en'=>'اجرت',
            'slug'=>'',
        ],
        [
            'name_prs'=>'خوراکه',
            'name_ps'=>'خوراکه',
            'name_en'=>'خوراکه',
            'slug'=>'',
        ],
        [
            'name_prs'=>'عراده جات',
            'name_ps'=>'عراده جات',
            'name_en'=>'عراده جات',
            'slug'=>'vehicles',
        ],
    ]);
    }
}
