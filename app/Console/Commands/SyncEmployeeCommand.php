<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Types\SyncEmployee;

class SyncEmployeeCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'hr:sync-employee';
    protected $description = 'Call the API';

    public function __construct()
    {
        parent::__construct();
    }
    public function handle()
    {
        SyncEmployee::operate();
    }

}
