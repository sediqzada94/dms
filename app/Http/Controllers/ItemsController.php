<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Category;
use App\Models\UnitOfMeasure;
use App\Models\ItemType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ItemsController extends Controller
{
    // protected $m7_details;
    protected $item;
    public function __construct(Item $item)
    {
        $this->item   = $item;
    }
public function index(Request $request) {
    $data['items'] = $this->item->getItems();
    $data['categories'] = getRecordFromTable('categories');
    $data['item_types'] = getRecordFromTable('item_types');
    $data['unit_of_measures'] = getRecordFromTable('unit_of_measures');
    if($request->ajax()){
        return (new Item())->items($request);
    }
    return view('settings.items.index', $data);
}
public function store(Request $request){
    $validator = Validator::make($request->all(), [
        'name_prs' => 'required',
        'name_ps' => 'required',
        'name_en' => 'required',
        'category_id' => 'required',
        'unit_of_measure_id' => 'required',
        'item_type_id' => 'required',
    ]);
    if ($validator->fails()) {
        return response()->json([
            'status' => 400,
            'message' => __('general_words.missing_inputs_or_duplicate_number'),
            'errors' => $validator->messages()
        ]);
    }
        else {
            try {
                DB::beginTransaction();
                $Items = $this->item->create([
                    'category_id' => $request->category_id,
                    'unit_of_measure_id' => $request->unit_of_measure_id,
                    'item_type_id' => $request->item_type_id,
                    'quantity_threshold' => $request->quantity_threshold,
                    'name_en' => $request->name_en,
                    'name_ps' => $request->name_ps,
                    'name_prs' => $request->name_prs,
                    'description' => $request->description,
                    'created_by' => auth()->user()->id
                ]);
              
                // insertFlow('fecen9_flows', 'fecen9_id', $fecen9->id);
                // insertLog('fecen9s', __('general_words.store'),  '/fc9/' . $fecen9->id, __('fc9.fc9'), $fecen9->id, $fecen9, null, $request);
                DB::commit();
                return response()->json([
                    'id' => $Items->id,
                    'status' => 200,
                    'message' => __('general_words.record_saved'),
                ]);
            } catch (\Exception $e) {
                DB::rollBack();
                \Log::error($e);
                return response()->json([
                    'status' => 400,
                    'message' => __('general_words.something_went_wrong'),
                    'errors' => $e
                ]);
            }
    } 
}


public function edit($id)
{
    $data = $this->item->find($id);
    $data->selected_item_type = getRecordFromTable('item_types', $data->item_type_id);
    $data->selected_category = getRecordFromTable('categories', $data->category_id);
    $data->selected_measure = getRecordFromTable('unit_of_measures', $data->unit_of_measure_id);
    return $data;
}
public function update(Request $request, $id)
{
    // return $id;
    $validator = Validator::make($request->all(), [
        'name_prs' => 'required',
        'name_ps' => 'required',
        'name_en' => 'required',
        'category_id' => 'required',
        'unit_of_measure_id' => 'required',
        'item_type_id' => 'required',
    ]);
    if ($validator->fails()) {
        return response()->json([
            'status' => 400,
            'message' => __('general_words.missing_inputs'),
            'errors' => $validator->messages()
        ]);
    } else {
        try {
            $details = Item::find($id);
            DB::beginTransaction();
            $update = $details->update([
                'category_id' => $request->category_id,
                'unit_of_measure_id' => $request->unit_of_measure_id,
                'item_type_id' => $request->item_type_id,
                'name_en' => $request->name_en,
                'name_prs' => $request->name_prs,
                'name_ps' => $request->name_ps,
                'description' => $request->description,
                'quantity_threshold' => $request->quantity_threshold,
                'updated_by' => auth()->user()->id
            ]);
            // insertLog('fecen9_details', __('general_words.update_item'),   '/fc9/' . $request->fecen9_id, __('fc9.fc9'), $details->fecen9_id, $update,$details, $request);
            DB::commit();
            return response()->json([
                'status' => 200,
                'item' => $this->item->getItems(null, $id),
                'message' => __('general_words.record_updated'),
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error($e);
            return response()->json([
                'status' => 400,
                'message' => __('general_words.something_went_wrong'),
                'errors' => $e
            ]);
        }
   }
}
public function destroy($id)
{
    $item = Item::find($id);
    if($item)
    {
        $item->delete();
        return response()->json([
            'status'=>200,
            'message'=>'item Deleted Successfully.'
        ]);
    }
    else
    {
        return response()->json([
            'status'=>404,
            'message'=>'No item Found.'
        ]);
    }
}
}
