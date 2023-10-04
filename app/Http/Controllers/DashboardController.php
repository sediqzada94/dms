<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    protected $item;
    public function __construct(Item $item)
    {
    $this->item = $item;
    }
    public function dashboard()
    {
        // $data['items_in_fiscal_year'] = $this->item->getItemsInFiscalYear();
        // dd( $data['items_in_fiscal_year']);
        // $data['items'] =  $this->item->lastDistrebutedItems();
        // $data['fecen5_count'] = DB::select('SELECT count(id) as total_count,fc5.id,fc5.fecen5_number, ReturnLastFormFlow("fecen5_flows", fc5.id) as last_status FROM `fecen5s` as fc5 group by last_status');
        // $data['fecen9_count'] = DB::select('SELECT count(id) as total_count,fc9.id,fc9.fecen9_number, ReturnLastFormFlow("fecen9_flows", fc9.id) as last_status FROM `fecen9s` as fc9 group by last_status');
        // $data['fecen1_count'] = DB::select('SELECT count(id) as total_count,fc1.id,fc1.fecen1_number, ReturnLastFormFlow("fecen1_flows", fc1.id) as last_status FROM `fecen1s` as fc1 group by last_status');
        // $data['fecen4_count'] = DB::select('SELECT count(id) as total_count,fc4.id,fc4.fecen4_number, ReturnLastFormFlow("fecen4_flows", fc4.id) as last_status FROM `fecen4s` as fc4 group by last_status');
        // $data['fecen8_count'] = DB::select('SELECT count(id) as total_count,fc8.id,fc8.fecen8_number, ReturnLastFormFlow("fecen8_flows", fc8.id) as last_status FROM `fecen8s` as fc8 group by last_status');
        // $data['meem7_count']  = DB::select('SELECT count(id) as total_count,m7.id,m7.meem7_number, ReturnLastFormFlow("meem7_flows", m7.id) as last_status FROM `meem7s` as m7 group by last_status');
        // $data['sejel_count']  = DB::select('SELECT count(id) as total_count,sejel.id,sejel.sejel_number, ReturnLastFormFlow("sejel_flows", sejel.id) as last_status FROM `sejels` as sejel group by last_status');
        // $data['moblin_count']  = DB::select('SELECT count(id) as total_count,moblin.id, ReturnLastFormFlow("moblin_flows", moblin.id) as last_status FROM `moblins` as moblin group by last_status');
        // $data['repairing_count']  = DB::select('SELECT count(id) as total_count,repairing.id, ReturnLastFormFlow("repairing_flows", repairing.id) as last_status FROM `repairings` as repairing group by last_status');
        // $data['repairing_count']  = DB::select('SELECT count(id) as total_count,repairing.id, ReturnLastFormFlow("repairing_flows", repairing.id) as last_status FROM `repairings` as repairing group by last_status');
    //    dd($data['fecen5_count']);
        return view('dashboard');
    }
}
