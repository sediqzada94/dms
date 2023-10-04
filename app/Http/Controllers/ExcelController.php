<?php

namespace App\Http\Controllers;

use App\Exports\Fecen9Export;
use App\Exports\GeneralSample;
use App\Models\CardToCard;
use App\Models\Fecen1;
use App\Models\Fecen4;
use App\Models\Fecen5;
use App\Models\Fecen8;
use App\Models\Fecen9;
use App\Models\Item;
use App\Models\Meem7;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ExcelController extends Controller
{
    public function export(Request $request, $type = null, $form_id = null)
    {
        $file_name = 'test' . '.xlsx';
        if ($type == 'fc9') {
            return Excel::download(new Fecen9Export($type, $form_id), $file_name);
        }
//        Fahim


        if ($request->type == 'fc9list') {
            $data = (new Fecen9())->exportToExcel($request);
            $collection = collect($data);
            $lenght = count($data);
            $myArray = [];
            $newData = $collection->map(function ($datad, $key) {
                $myArray = [
                    'no' => ++$key,
                    'fecen9_number' => $datad->fecen9_number,
                    'directorate' => $datad->dir_name,
                    'date' => $datad->issue_date,
                    'employee' => $datad->employee,
                    'item_name' => $datad->item_name,
                    'item_specification' => $datad->item_specification,
                    'quantity' => $datad->quantity,
                    'measure' => $datad->measure,
                    'remark' => $datad->remark,
                ];
                return $myArray;
            });
            $header = [
                __('general_words.number'),
                __('fc9.fc9_number'),
                __('fc9.request_directorate'),
                __('general_words.date'),
                __('general_words.employee'),
                __('general_words.item_name'),
                __('general_words.item_specification'),
                __('general_words.quantity'),
                __('general_words.unit_of_measure'),
                __('general_words.remark'),
            ];

            // return $newData;
            $column_size = [7, 15, 25, 12, 20, 20, 35, 10, 10, 35];
            $export = new GeneralSample([$newData], $lenght, $type, $header, $column_size, __('fc9.fc9'));
            return Excel::download($export, 'Fc9 list.xlsx');
        }
//        Export card to card
        if ($request->type == 'card_to_card_list') {
            $data = (new CardToCard())->exportToExcel($request);
            $collection = collect($data);
            $lenght = count($data);
            $myArray = [];
            $newData = $collection->map(function ($datad, $key) {
                $myArray = [
                    'no' => ++$key,
                    'date' => miladiToHijriOrJalali($datad->date),
                    'fromEmployee' => $datad->fromEmployee,
                    'toEmployee' => $datad->toEmployee,
                    'remark' => $datad->remark,
                    'item_name' => $datad->item_name,
                    'item_status' => $datad->item_status,
                    'item_specification' => $datad->item_specification,
                    'quantity' => $datad->quantity,
                    'price' => $datad->unit_price,
                    'serial_number' => $datad->serial_number,
                    'tag_number' => $datad->tag_number,
                    'measure' => $datad->measure,
                    'total_price' => $datad->quantity * $datad->unit_price,
                ];
                return $myArray;
            });
            $header = [
                __('general_words.number'),
                __('general_words.date'),
                __('card_to_card.submitted_to_name'),
                __('card_to_card.submitter_name'),
                __('general_words.remark'),
                __('general_words.item_name'),
                __('general_words.item_status'),
                __('general_words.item_specification'),
                __('general_words.quantity'),
                __('general_words.price'),
                __('general_words.serial_number'),
                __('general_words.tag_number'),
                __('general_words.unit_of_measure'),
                __('general_words.total_price'),
            ];

            // return $newData;
            $column_size = [7, 15, 25, 12, 20, 20, 15, 35, 10, 10, 20, 20, 10, 15];
            $export = new GeneralSample([$newData], $lenght, $type, $header, $column_size, __('general_words.item_general_report'));
            return Excel::download($export, 'item general report.xlsx');
        }
//        Export Items reports
        if ($request->type == 'general_report') {
            $data = (new Item())->itemReport($request);
            $collection = collect($data);
            $lenght = count($data);
            $myArray = [];
            $newData = $collection->map(function ($datad, $key) {
                $myArray = [
                    'no' => ++$key,
                    'name' => $datad->name,
                    'measure' => $datad->measure,
                    'category' => $datad->category,
                    'status' => $datad->status,
                    'type' => $datad->type,
                    'directorate' => $datad->directorate,
                    'employee' => $datad->employee,
                    'mtamed' => $datad->motamed,
                    'fiscal_year' => $datad->fiscal_year,
                    'quantity' => $datad->total,
                    'in_out' => $datad->distributed,
                ];
                return $myArray;
            });
            $header = [
                __('general_words.number'),
                __('general_words.name'),
                __('general_words.unit_of_measure'),
                __('general_words.category'),
                __('general_words.item_status'),
                __('general_words.item_type'),
                __('general_words.directorate'),
                __('card_to_card.submitted_to_name'),
                __('general_words.motamed'),
                __('general_words.fiscal_year'),
                __('general_words.available_items'),
                __('general_words.distributed_items'),
            ];
            $column_size = [7, 15,15,15,15,15,15,15,15,15,15,15,15];
            $export = new GeneralSample([$newData], $lenght, $type, $header, $column_size, __('general_words.distributed_items'));
            return Excel::download($export, 'distributed items.xlsx');
        }
//        download distributed items report
        if ($request->type == 'depreciation_report') {
            $data = (new Item())->itemReport($request);
            $collection = collect($data);
            $lenght = count($data);
            $myArray = [];
            $newData = $collection->map(function ($datad, $key) {
                // $datad->spec = $datad->spec .': '. $datad->chassis ? ''. $datad->chassis : '' ;
                $myArray = [
                    'no' => ++$key,
                    'name' => $datad->name,
                    'measure' => $datad->measure,
                    'description' => $datad->spec, 
                    'type' => $datad->type,
                    'status' => $datad->status,
                    'category' => $datad->category,
                    'serial_number' => $datad->serial_number ? $datad->serial_number : $datad->chassis,
                    'tag_number' => $datad->tag_number,
                    'form_number' => $datad->form_number,
                    'date' => miladiToHijriOrJalali($datad->date),
                    'employee' => $datad->employee,
                    'motamed' => $datad->motamed,
                    'purchase_type' => $datad->purchase_type,
                    'donor' => $datad->donor,
                    'company' => $datad->company,
                ];
                return $myArray;
            });
            $header = [
                __('general_words.number'),
                __('general_words.name'),
                __('general_words.unit_of_measure'),
                __('general_words.description'),
                __('general_words.item_type'),
                __('general_words.item_status'),
                __('general_words.category'),
                __('general_words.serial_number'),
                __('general_words.tag_number'),
                __('general_words.form_number'),
                __('general_words.date'),
                __('general_words.employee'),
                __('general_words.motamed'),
                __('general_words.purchase_type'),
                __('general_words.company'),
                __('general_words.donor'),
            ];
            $column_size = [7,15,15,25,15,15,15,15,15,15,15,15,15,15,15,15];
            $export = new GeneralSample([$newData], $lenght, $type, $header, $column_size, __('general_words.depreciation_item_history'));
            return Excel::download($export, 'Fc9 list.xlsx');
        }
        if ($request->type == 'distributed_report') {
            $data = (new Item())->itemReport($request);
            $collection = collect($data);
            $lenght = count($data);
            $myArray = [];
            $newData = $collection->map(function ($datad, $key) {
                $myArray = [
                    'no' => ++$key,
                    'name' => $datad->name,
                    'measure' => $datad->measure,
                    'description' => $datad->spec,
                    'type' => $datad->type,
                    'status' => $datad->status,
                    'category' => $datad->category,
                    'distributed' => $datad->distributed,
                    'fiscal_year' => $datad->fiscal_year,
                    'directorate' => $datad->directorate,
                    'employee' => $datad->employee,
                    'motamed' => $datad->motamed,
                    'donor' => $datad->donor,
                    'company' => $datad->company,
                    'purchase_type' => $datad->purchase_type,
                ];
                return $myArray;
            });
            $header = [
                __('general_words.number'),
                __('general_words.name'),
                __('general_words.unit_of_measure'),
                __('general_words.description'),
                __('general_words.item_type'),
                __('general_words.item_status'),
                __('general_words.category'),
                __('general_words.total_distributed'),
                __('general_words.fiscal_year'),
                __('general_words.directorate'),
                __('card_to_card.submitted_to_name'),
                __('general_words.motamed'),
                __('general_words.donor'),
                __('general_words.company_waja'),
                __('general_words.purchase_type'),
            ];
            $column_size = [7, 15,15,25,15,15,15,15,15,15,15,15,15,15,15,15];
            $export = new GeneralSample([$newData], $lenght, $type, $header, $column_size, __('card_to_card.card_to_card'));
            return Excel::download($export, 'Fc9 list.xlsx');
        }


//Stanikzai
        if ($request->type == 'm7list') {
            $data = (new Meem7())->exportToExcel($request);
            $collection = collect($data);
            $lenght = count($data);
            $myArray = [];
            $newData = $collection->map(function ($datad, $key) {
                $myArray = [
                    'no' => ++$key,
                    'meem7_number' => $datad->meem7_number,
                    'date' => $datad->meem7_date,
                    'fiscal_year' => $datad->fiscal_year,
                    'donor_name' => $datad->donor_name,
                    'vendor_name' => $datad->vendor_name ? $datad->vendor_name : $datad->obtained_from,
                    'item_name' => $datad->item_name,
                    'item_specification' => $datad->item_specification,
                    'item_category' => $datad->item_category,
                    'measure' => $datad->item_measure,
                    'item_type' => $datad->item_type,
                    'item_status' => $datad->item_status,
                    'quantity' => $datad->item_quantity,
                    'item_measure' => $datad->item_measure,
                    'unit_price' => $datad->item_unit_price,
                    'motamed' => $datad->motamed_name,
                ];
                return $myArray;
            });
            $header = [
                __('general_words.number'),
                __('m7.meem7_number'),
                __('general_words.date'),
                __('general_words.fiscal_year'),
                __('general_words.donor'),
                __('general_words.vendor').'/'.__('m7.obtain'),
                __('general_words.item_name'),
                __('general_words.item_specification'),
                __('general_words.category'),
                __('general_words.unit_of_measure'),
                __('general_words.item_type'),
                __('general_words.item_status'),
                __('general_words.quantity'),
                __('general_words.unit_of_measure'),
                __('general_words.unit_price'),
                __('m7.stock_keeper'),
            ];

            // return $newData;
            $column_size = [7, 15, 25, 12, 15, 30, 10, 20, 20, 20, 20, 35, 10, 10, 10, 35];
            $export = new GeneralSample([$newData], $lenght, $type, $header, $column_size, __('m7.m7'));
            return Excel::download($export, 'M7 list.xlsx');
        }


//        Sami jan
//       FC5 Excel
        if ($request->type == 'fc5list') {
            $data = (new Fecen5())->exportToExcel($request);
            $collection = collect($data);
            $lenght = count($data);
            $myArray = [];
            $newData = $collection->map(function ($datad, $key) {
                $myArray = [
                    'no' => ++$key,
                    'fecen5_number' => $datad->fecen5_number,
                    'fecen9_number' => $datad->fecen9_number,
                    'directorate_name' => $datad->directorate_name,
                    'issue_date' => miladiToHijriOrJalali($datad->issue_date),
                    'fiscal_year' => $datad->fiscal_year,
                    'remark' => $datad->remark,
                    'hangar_name' => $datad->hangar_name,
                    'employee_name' => $datad->employee_name,
                    'item_name' => $datad->item_name,
                    'item_specification' => $datad->item_specification,
                    'unit_of_measure_name' => $datad->unit_of_measure_name,
                    'item_quantity' => $datad->item_quantity,
                    'unit_price' => $datad->unit_price,
                    'tag_number' => $datad->tag_number,
                    'serial_number' => $datad->serial_number,
                ];
                return $myArray;
            });
            $header = [
                __('general_words.number'),
                __('fc5.fc5_number'),
                __('fc9.fc9_number'),
                __('fc9.request_directorate'),
                __('general_words.date'),
                __('general_words.fiscal_year'),
                __('general_words.remark'),
                __('general_words.hangar'),
                __('general_words.employee'),
                __('general_words.item_name'),
                __('general_words.item_specification'),
                __('general_words.unit_of_measure'),
                __('general_words.quantity'),
                __('general_words.price'),
                __('general_words.tag_number'),
                __('general_words.serial_number'),
            ];
            $column_size = [7, 15, 15, 25, 15, 10, 35, 15, 20, 15, 40, 10, 15, 20, 20, 15];
            $export = new GeneralSample([$newData], $lenght, $type, $header, $column_size, __('fc5.fc5'));
            return Excel::download($export, 'fc5 list.xlsx');
        }
        //      FC1 Excel
        if ($request->type == 'fc1list') {
            $data = (new Fecen1())->exportToExcel($request);
            $collection = collect($data);
            $lenght = count($data);
            $myArray = [];
            $newData = $collection->map(function ($datad, $key) {
                return $myArray = [
                    'no' => ++$key,
                    'fecen1_number' => $datad->fecen1_number,
                    'date' => miladiToHijriOrJalali($datad->issue_date),
                    'remark' => $datad->remark,
                    'auction_reasons' => $datad->auction_reasons,
                    'item_name' => $datad->item_name,
                    'item_quantity' => $datad->quantity,
                    'unit_of_measure_name' => $datad->unit_of_measure_name,
                    'unit_price' => $datad->unit_price,
                    'detail_remark' => $datad->detail_remark,
                    'tag_number' => $datad->tag_number,
                    'serial_number' => $datad->serial_number,
                ];
            });
            $header = [
                __('general_words.number'),
                __('fc1.fc1_number'),
                __('general_words.date'),
                __('general_words.remark'),
                __('fc1.auction_reasons'),
                __('general_words.item_name'),
                __('general_words.quantity'),
                __('general_words.unit_of_measure'),
                __('general_words.price'),
                __('general_words.remark'),
                __('general_words.tag_number'),
                __('general_words.serial_number'),
            ];
            $column_size = [7, 15, 15, 25, 25, 10, 10, 10, 10, 30, 15, 15];
            $export = new GeneralSample([$newData], $lenght, $type, $header, $column_size, __('fc1.fc1'));
            return Excel::download($export, 'Fc1 list.xlsx');
        }

//        Naiem
        if ($request->type == 'fc4list') {
            $data = (new Fecen4())->exportToExcel($request);
            $collection = collect($data);
            $lenght = count($data);
            $myArray = [];
            $newData = $collection->map(function ($datad, $key) {
                $myArray = [
                    'no' => ++$key,
                    'fecen4_number' => $datad->fecen4_number,
                    'employee' => $datad->dir_name,
                    'emp' => $datad->emp_name,
                    'date' => miladiToHijriOrJalali($datad->stock_date),
                    'name' => $datad->name,
                    'description' => $datad->description,
                    'measure' => $datad->measure,
                    'quantity' => $datad->commitee_quantity,
                    'storage_quantity' => $datad->storage_quantity,
                    'remain_qty' => $datad->remain_qty,
                    'remaind_qty' => $datad->remaind_qty,
                    'remark' => $datad->remark,
                ];
                return $myArray;
            });
            $header = [
                __('general_words.number'),
                __('fc4.fc4_number'),
                __('fc4.stock_by'),
                __('fc4.control_by'),
                __('general_words.date'),
                __('general_words.item_name'),
                __('general_words.item_specification'),
                __('general_words.unit_of_measure'),
                __('fc4.item_count_based_on_committee'),
                __('fc4.item_count_based_on_storage_card'),
                __('fc4.item_remained'),
                __('fc4.item_remains'),
                __('general_words.remark'),
            ];

            // return $newData;
            $column_size = [7, 15, 25, 25, 20, 20, 35, 30, 30, 20, 15, 15, 35];
            $export = new GeneralSample([$newData], $lenght, $type, $header, $column_size, __('fc4.fc4'));
            return Excel::download($export, 'Fc4 list.xlsx');
        }
        if ($request->type == 'fc8list') {
            $data = (new Fecen8())->exportToExcel($request);
            $collection = collect($data);
            $lenght = count($data);
            $myArray = [];
            $newData = $collection->map(function ($datad, $key) {
                $myArray = [
                    'no' => ++$key,
                    'fecen8_number' => $datad->fecen8_number,
                    'directorate' => $datad->dir_name,
                    'date' => miladiToHijriOrJalali($datad->issue_date),
                    'motamed' => $datad->motamed,
                    'item_name' => $datad->item_name,
                    'description' => $datad->description,
                    'item_status' => $datad->item_status,
                    'measure' => $datad->measure,
                    'quantity' => $datad->quantity,
                    'tag_number' => $datad->tag_number,
                    'serial_number' => $datad->serial_number,
                    'additional_info' => $datad->additional_info,
                ];
                return $myArray;
            });
            $header = [
                __('general_words.number'),
                __('fc8.fc8_number'),
                __('general_words.directorate'),
                __('general_words.date'),
                __('general_words.motamed'),
                __('general_words.item_name'),
                __('general_words.item_specification'),
                __('general_words.item_status'),
                __('general_words.unit_of_measure'),
                __('general_words.quantity'),
                __('general_words.tag_number'),
                __('general_words.serial_number'),
                __('general_words.additional_info'),
            ];

            // return $newData;
            $column_size = [7, 15, 25, 12, 20, 20, 35, 10,10, 10,10,10, 35];
            $export = new GeneralSample([$newData], $lenght, $type, $header, $column_size, __('fc8.fc8'));
            return Excel::download($export, 'Fc8 list.xlsx');
        }
        if ($request->type == 'vehicle_expenses') {
            $data = (new Item())->itemReport($request);
            $collection = collect($data);
            $lenght     = count($data);
            $myArray = [];
            $newData = $collection->map(function ($datad, $key) {
                $myArray = [
                    'no' => ++$key,
                    'sejel_no' => $datad->sejel_number,
                    'vehicle' => $datad->vehicle,
                    'driver' => ($datad->driver),
                    'parts' => $datad->item_name,
                    'distributed_quantity' => $datad->distributed_quantity,
                    'price' => $datad->price,
                    'total_price' => $datad->distributed_quantity*$datad->price,
                    'fiscal_year' => $datad->fiscal_year,
                    'distributed_date' => $datad->fecen5_date,
                ];
                return $myArray;
            });
            $header = [
                __('general_words.number'),
                __('general_words.sejel_no'),
                __('general_words.vehicle'),
                __('general_words.driver'),
                __('general_words.parts'),
                __('general_words.distributed_quantity'),
                __('general_words.price'),
                __('general_words.total_price'),
                __('general_words.fiscal_year'),
                __('general_words.distributed_date'),
            ];

            // return $newData;
            $column_size = [7, 15, 25, 35, 20,20, 10,20,10, 35];
            $export = new GeneralSample([$newData], $lenght, $type, $header, $column_size, __('general_words.vehicle_exp'));
            return Excel::download($export, 'Driver Expense list.xlsx');
        }
    }


}
