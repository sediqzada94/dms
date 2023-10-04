<?php

namespace App\Models;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class UnitOfMeasure extends Model
{
    //
    protected $table = 'unit_of_measures';

    protected $fillable=[
        'name_prs',
        'name_en',
        'name_ps',
    ];
    public function items()
    {
        return $this->hasMany(Item::class);
    }
    public function measureList($request){
        $filter = $request->input('search_keyword');
        $per_page = $request->input('per_page') ? $request->input('per_page') : 10;
        $start_page = $request->input('current_page');
        $order_by = $request->input('order_by');
        $order_direction = $request->input('order_direction');
        $name_prs   = $request->name_prs;
        $name_ps  = $request->name_ps;
        $query = DB::table('unit_of_measures')
        ->selectRaw('unit_of_measures.*,unit_of_measures.name_'.lang().' as measure
            ');
       
        if ($order_direction != '' || $order_by != '') {
            $query = $query->orderBy($order_by, $order_direction);
        }
        if ($filter != '') {
            $query->where('unit_of_measures.name_'.lang(),'like', '%' . $filter . '%');
    
        }
       
        if ($name_prs != 'null') {
            $query = $query->where('unit_of_measures.name_prs',$name_prs);
        }
        if ($name_ps != 'null') {
            $query = $query->where('unit_of_measures.name_ps',$name_ps);
        }
        Paginator::currentPageResolver(function () use ($start_page) {
            return $start_page;
        });
        $query = $query->paginate($per_page);
        return $query;
    } 
}
