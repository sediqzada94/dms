<?php
namespace Database\Seeders;
use Carbon\Carbon;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            // required for production
        // CategoriesTableSeeder::class,
        // HangarTableSeeder::class,
        // PermissionsTableSeeder::class,
        // RolesTableSeeder::class,
        // ItemStatusesTableSeeder::class,
        // ItemTypesTableSeeder::class,
        // UnitOfMeasuresTableSeeder::class,
        // UsersTableSeeder::class,
        // PositionTableSeeder::class,
// ==================for development===================================
        // DirectoratesTableSeeder::class,
        // EmployeesTableSeeder::class,
        // MotamedsTableSeeder::class,
        // DepartmentsTableSeeder::class,
        // DonorsTableSeeder::class,
        // ItemsTableSeeder::class,
        // VendorsTableSeeder::class,
        // Meem7sTableSeeder::class,
        // Meem7DetailsTableSeeder::class,
        // Fecen1sTableSeeder::class,
        // Fecen9sTableSeeder::class,
        // Fecen5sTableSeeder::class
        ]
    );
    DB::table('doc_types')->insert([[
        'name' => 'عریضه',
        'created_at' => Carbon::now()
      ],
      [
        'name' => 'مکتوب',
        'created_at' => Carbon::now()
      ],
      [
        'name' => 'پیشنهاد',
        'created_at' => Carbon::now()
      ],
    ]);

  //Document
    DB::table('documents')->insert([[
        'title' => 'در مورد مشکل 1',
        'remark' => 'عریضه بعد از اجراعات به مرجع مربوطه ارسال شود',
        'created_at' => Carbon::now()
      ],
      [
        'title' => 'در مورد مشکل 2',
        'remark' => 'مکتوب بعد از اجراعات به مرجع مربوطه ارسال شود',
        'created_at' => Carbon::now()
      ],
      [
        'title' => 'در مورد مشکل 3',
        'remark' => 'پیشنهاد بعد از اجراعات به مرجع مربوطه ارسال شود',
        'created_at' => Carbon::now()
      ],
    ]);

  //Status
    DB::table('statuses')->insert([[
        'name' => 'انتظار',
        'created_at' => Carbon::now()
      ],
      [
        'name' => 'قبول شده',
        'created_at' => Carbon::now()
      ],
      [
        'name' => 'رد شده',
        'created_at' => Carbon::now()
      ],
    ]);

  //Deadline Type
    DB::table('deadline_types')->insert([[
        'name' => 'ثابت',
        'created_at' => Carbon::now()
      ],
      [
        'name' => 'متغیر',
        'created_at' => Carbon::now()
      ],
    ]);

    //Followup Type
    DB::table('followup_types')->insert([[
      'name' => 'اجرا',
      'created_at' => Carbon::now()
    ],
    [
      'name' => 'جواب',
      'created_at' => Carbon::now()
    ],
    [
      'name' => 'تعقیب ',
      'created_at' => Carbon::now()
    ],
  ]);

    //Security Level
    DB::table('security_levels')->insert([[
      'name' => 'عادی',
      'created_at' => Carbon::now()
    ],
    [
      'name' => 'محرم',
      'created_at' => Carbon::now()
    ],
    [
      'name' => 'ارشد محرم ',
      'created_at' => Carbon::now()
    ],
  ]);


    //Deadline
    DB::table('deadlines')->insert([[
      'days' => 3,
      'doc_type_id' => 1,
      'created_at' => Carbon::now()
    ],
    [
      'days' => 4,
      'doc_type_id' => 2,
      'created_at' => Carbon::now()
    ],
    [
      'days' => 5,
      'doc_type_id' => 3,
      'created_at' => Carbon::now()
    ],
  ]);


    //Trackers
    DB::table('trackers')->insert([[
      'sender_id' => 1,
      'receiver_id' => 1,
      'in_num' => '123',
      'out_num' => '1234',
      'in_date' => '2023-04-06',
      'out_date' => '2023-04-07',
      'request_deadline' => '3',
      'remark' => 'طبق مقررات اجرات نماید',
      'attachment_count' => '5',
      'deadline_id' => 1,
      'status_id' => 1,
      'deadline_type_id' => 1,
      'security_level_id' => 1,
      'followup_type_id' => 1,
      'document_id' => 1,
      'doc_type_id' => 1,
      'created_at' => Carbon::now()
    ],
    [
      'sender_id' => 2,
      'receiver_id' => 2,
      'in_num' => '223',
      'out_num' => '2234',
      'in_date' => '2023-02-02',
      'out_date' => '2023-02-03',
      'request_deadline' => '4',
      'remark' => 'اصولآ مقررات اجرات نماید',
      'attachment_count' => '6',
      'deadline_id' => 2,
      'status_id' => 2,
      'deadline_type_id' => 2,
      'security_level_id' => 2,
      'followup_type_id' => 2,
      'document_id' => 2,
      'doc_type_id' => 2,
      'created_at' => Carbon::now()
    ],

  ]);

    //Attachment / Tracker child
    DB::table('attachments')->insert([[
      'tracker_id' => 1,
      'path' => '134543.pdf',
      'created_at' => Carbon::now()
    ],
    [
      'tracker_id' => 2,
      'path' => '234543.pdf',
      'created_at' => Carbon::now()
    ],
    [
      'tracker_id' => 1,
      'path' => '334543.pdf',
      'created_at' => Carbon::now()
    ],
  ]);

    //Doc Copy / Tracker child
    DB::table('doc_copies')->insert([[
      'tracker_id' => 1,
      'emp_id' => 1,
      'created_at' => Carbon::now()
    ],
    [
      'tracker_id' => 2,
      'emp_id' => 2,
      'created_at' => Carbon::now()
    ],
    [
      'tracker_id' => 1,
      'emp_id' => 3,
      'created_at' => Carbon::now()
    ],
  ]);

    }
}
