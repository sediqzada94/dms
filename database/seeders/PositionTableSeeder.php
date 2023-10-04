<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PositionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('positions')->insert([[
            'name_en' => 'Deputy',
            'name_ps' => 'معین',
            'name_prs' => 'معین',
            'slug' => 'deputy',
        ],
            [
                'name_en' => 'General Director',
                'name_ps' => 'عمومی ریس',
                'name_prs' => 'ریس عمومی',
                'slug' => 'general-director',
            ],
            [
                'name_en' => 'Director',
                'name_ps' => 'ریس',
                'name_prs' => 'ریس',
                'slug' => 'director',
            ],
            [
                'name_en' => 'Services Director',
                'name_ps' => 'خدماتو ریس',
                'name_prs' => 'ریس خدمات',
                'slug' => 'services-director',
            ],
            [
                'name_en' => 'Department Head',
                'name_ps' => 'آمر',
                'name_prs' => 'آمر',
                'slug' => 'department-head',
            ],
            [
                'name_en' => 'Asset Management Head',
                'name_ps' => 'محاسبه جنسی آمر',
                'name_prs' => 'آمر محاسبه جنسی',
                'slug' => 'asset-management-head',
            ],
            [
                'name_en' => 'Asset Management General Manager',
                'name_ps' => 'مدیریت عمومی محاسبه جنسی',
                'name_prs' => 'محاسبه جنسی عمومی مدیر',
                'slug' => 'asset-management-general-manager',
            ],
            [
                'name_en' => 'Items Registration Manager',
                'name_ps' => 'د اجناسو د ثبت مدیر',
                'name_prs' => 'مدیر ثبت اجناس',
                'slug' => 'items-registration-manager',
            ],
            [
                'name_en' => 'Items Distribution Manager',
                'name_ps' => 'د اجناسو د توزیع مدیر',
                'name_prs' => 'مدیر توزیع اجناس ',
                'slug' => 'items-distribution-manager',
            ],
            [
                'name_en' => 'Stock General Manager',
                'name_ps' => 'د هنګر عمومی مدیر',
                'name_prs' => 'مدیر عمومی هنګر',
                'slug' => 'stock-general-manager',
            ],
            [
                'name_en' => 'IT Stock Manager ',
                'name_ps' => 'د هنګر د تکنالوژی د بخش مدیر',
                'name_prs' => 'مدیر بخش تکنالوژی هنګر',
                'slug' => 'it-stock-manager ',
            ],
            [
                'name_en' => 'Other Items Stock Manage',
                'name_ps' => 'د هنګر د نورو اجناسو مدیر',
                'name_prs' => 'مدیر بخش سایر اجناس هنګر',
                'slug' => 'other-items-stock-manager',
            ],
            [
                'name_en' => 'Storage Registration Manager',
                'name_ps' => 'آمر',
                'name_prs' => 'مدیر ثبت ذخیره',
                'slug' => 'storage-registration-manager',
            ],
            [
                'name_en' => 'Storage Registration Employee',
                'name_ps' => 'د ثبت ذخیری مامور',
                'name_prs' => 'مامور ثبت ذخیره',
                'slug' => 'storage-registration-employee',
            ],
            [
                'name_en' => 'Depreciation Items Storage Registration Employee',
                'name_ps' => 'د داغمه شوی اجناسو د ثبت ذخیری مامور',
                'name_prs' => 'مامور ثبت و ذخیره اجناس داغمه',
                'slug' => 'depreciation-items-storage-registration-employee',
            ],
            [
                'name_en' => 'Other',
                'name_ps' => 'نو',
                'name_prs' => 'دیگر',
                'slug' => 'other',
            ],

        ]);
    }
}
