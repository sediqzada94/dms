<?php

namespace App\Http\Controllers;

use DB;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $category;
    public function __construct(Category $category)
    {
        $this->category   = $category;
    }
    public function index(Request $request)
    {
        // $data['Categories']=DB::table('categories')->get();
        // $data['directorates'] = (new Directorate())->getDirectorate();
        if ($request->ajax()) {
            return $this->category->categoryList($request);
        }
        return view('settings.category.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'name_prs' => 'required',
         
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
                    $slug = $request->name_en ? Str::slug($request->name_en) : '';
                    $categories = $this->category->create([
                        'name_en' => $request->name_en,
                        'slug' => $slug,
                        'name_prs' => $request->name_prs,
                        'name_ps' => $request->name_ps,
                        'created_by' => auth()->user()->id
                    ]);
                    // insertFlow('fecen9_flows', 'fecen9_id', $fecen9->id);
                    // insertLog('fecen9s', __('general_words.store'),  '/fc9/' . $fecen9->id, __('fc9.fc9'), $fecen9->id, $fecen9, null, $request);
                   DB::commit();
                    return response()->json([
                        'id' => $categories->id,
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

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = $this->category->find($id);
        // $data->selected_dir = getRecordFromTable('directorates', $data->directorate_id);
        return $data;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
   

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // return $id;
        $validator = Validator::make($request->all(), [
            'name_prs' => 'required',
           
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'message' => __('general_words.missing_inputs'),
                'errors' => $validator->messages()
            ]);
        } else {
            try {
                $slug = $request->name_en ? Str::slug($request->name_en) : '';
                $details = Category::find($id);
                DB::beginTransaction();
                $update = $details->update([
                    'name_en' => $request->name_en,
                    'slug' => $slug,
                    'name_prs' => $request->name_prs,
                    'name_ps' => $request->name_ps,
                    'updated_by' => auth()->user()->id
                ]);
                // insertLog('fecen9_details', __('general_words.update_item'),   '/fc9/' . $request->fecen9_id, __('fc9.fc9'), $details->fecen9_id, $update,$details, $request);
                DB::commit();
                return response()->json([
                    'status' => 200,
                    'category' => $this->category->find($id),
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

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
