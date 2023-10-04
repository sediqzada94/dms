<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Casts\Attribute;
class Category extends Model
{
    protected $table="categories";
    protected $fillable =[
        'name_en',
        'slug',
        'name_ps',
        'name_prs'
    ];

public function item() {
    return $this->hasMany(Item::class);
}
public function categoryList($request){
    $filter = $request->input('search_keyword');
    $per_page = $request->input('per_page') ? $request->input('per_page') : 10;
    $start_page = $request->input('current_page');
    $order_by = $request->input('order_by');
    $order_direction = $request->input('order_direction');
    $name_prs   = $request->name_prs;
    $name_ps  = $request->name_ps;
    $query = DB::table('categories')
    ->selectRaw('categories.*,categories.name_'.lang().' as category
        ');
   
    if ($order_direction != '' || $order_by != '') {
        $query = $query->orderBy($order_by, $order_direction);
    }
    if ($filter != '') {
        $query->where('categories.name_'.lang(),'like', '%' . $filter . '%');

    }
   
    if ($name_prs != 'null') {
        $query = $query->where('categories.name_prs',$name_prs);
    }
    if ($name_ps != 'null') {
        $query = $query->where('categories.name_ps',$name_ps);
    }
    Paginator::currentPageResolver(function () use ($start_page) {
        return $start_page;
    });
    $query = $query->paginate($per_page);
    return $query;
}    
}
