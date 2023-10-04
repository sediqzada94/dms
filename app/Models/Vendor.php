<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Casts\Attribute;
class Vendor extends Model
{
    protected $table = 'vendors';

    protected $fillable=[
        'name_prs',
        'name_en',
        'name_ps',
        'phone',
        'bank_account'
    ];
    public function meem7s()
    {
        return $this->hasMany(Meem7::class);
    }
    public function vendorList($request){
        $filter = $request->input('search_keyword');
        $per_page = $request->input('per_page') ? $request->input('per_page') : 10;
        $start_page = $request->input('current_page');
        $order_by = $request->input('order_by');
        $order_direction = $request->input('order_direction');
        $name_prs   = $request->name_prs;
        $name_ps  = $request->name_ps;
       
        $query = DB::table('vendors')
        ->selectRaw('vendors.*,vendors.name_'.lang().' as vender,vendors.phone,vendors.bank_account
            ');
       
        if ($order_direction != '' || $order_by != '') {
            $query = $query->orderBy($order_by, $order_direction);
        }
        if ($filter != '') {
            $query->where('vendors.name_'.lang(),'like', '%' . $filter . '%')
            ->orWhere('vendors.phone','like', '%' . $filter . '%')
            ->orWhere('vendors.bank_account','like', '%' . $filter . '%');
    
        }
       
        if ($name_prs != 'null') {
            $query = $query->where('vendors.name_prs',$name_prs);
        }
        if ($name_ps != 'null') {
            $query = $query->where('vendors.name_ps',$name_ps);
        }
        Paginator::currentPageResolver(function () use ($start_page) {
            return $start_page;
        });
        $query = $query->paginate($per_page);
        return $query;
    } 
    //    get all Vendors for the first time and when search
    public function getVendor($keyword=null)
    {
        $query   = $this->selectRaw('name_'.lang().' as name, id')->limit(10);
        if($keyword){
            $query->where('name_'.lang(),'like', '%' . $keyword . '%');
        }
        return $query->get();
    }
}
