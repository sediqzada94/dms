<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Hangar extends Model
{
    use HasFactory;
    protected $table = 'hangars';

    protected $fillable=[

        'name_en',
        'name_ps',
        'name_prs',
        'description',
    ];
    public function motamed() {
        return $this->hasMany(Motamed::class);
    }
    public function hangarList($request){
        $filter = $request->input('search_keyword');
        $per_page = $request->input('per_page') ? $request->input('per_page') : 10;
        $start_page = $request->input('current_page');
        $order_by = $request->input('order_by');
        $order_direction = $request->input('order_direction');
        $name_prs   = $request->name_prs;
        $name_ps  = $request->name_ps;
        $query = DB::table('hangars')
        ->selectRaw('hangars.*,hangars.name_'.lang().' as hangar_name,hangars.id as hangar_id
            ');
       
        if ($order_direction != '' || $order_by != '') {
            $query = $query->orderBy($order_by, $order_direction);
        }
        if ($filter != '') {
            $query->where('hangars.name_'.lang(),'like', '%' . $filter . '%');
 
        }
       
        if ($name_prs != 'null') {
            $query = $query->where('hangars.name_prs',$name_prs);
        }
        if ($name_ps != 'null') {
            $query = $query->where('hangars.name_ps',$name_ps);
        }
        Paginator::currentPageResolver(function () use ($start_page) {
            return $start_page;
        });
        $query = $query->paginate($per_page);
        return $query;
    }
}
