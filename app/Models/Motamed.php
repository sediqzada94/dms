<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\Paginator;
class Motamed extends Model
{
    use HasFactory;
    protected $table='motameds';
    protected $fillable=[
        'hangar_id',
        'employee_id',
        'name',
        'last_name',
        'father_name',
        'position',
        'gender',
        'phone',
        'email',
        'directorate',
        'department',
        'hire_status'
    ];
    public function hangar() {
        return $this->belongsTo(Hangar::class);
    }
    public function employee() {
        return $this->belongsTo(Employee::class);
    }
    public function meem7_details()
    {
        return $this->hasMany(Meem7Details::class, 'motamed_id');
    }

    public function getMotamed() {
        return $this->selectRaw('id, name, last_name, father_name, position')->get();
    }
    // Fun Created by naim
    public function motamedList($request){
        $filter = $request->input('search_keyword');
        $per_page = $request->input('per_page') ? $request->input('per_page') : 10;
        $start_page = $request->input('current_page');
        $order_by = $request->input('order_by');
        $order_direction = $request->input('order_direction');
        $name   = $request->name;
        $hangar_id  = $request->hangar_id;
        $query = DB::table('motameds')
        // ->leftJoin('employees', 'employees.id', '=', 'heiat_tashrih.employee_id')
        ->leftJoin('hangars', 'hangars.id', '=', 'motameds.hangar_id')
        ->selectRaw('motameds.*,hangars.name_'.lang().' as hangar_name,hangars.id as hangar_id
            ');
        if ($order_direction != '' || $order_by != '') {
            $query = $query->orderBy($order_by, $order_direction);
        }
        if ($filter != '') {
            $query->where('motameds.name','like', '%' . $filter . '%')
            ->orWhere('motameds.last_name','like', '%' . $filter . '%')
            ->orWhere('hangars.name_'.lang(),'like', '%' . $filter . '%')
            ->orWhereRaw('CONCAT(name, "-", father_name) LIKE ?', ['%' . $filter . '%']);
        }
      
        Paginator::currentPageResolver(function () use ($start_page) {
            return $start_page;
        });
        $query = $query->paginate($per_page);
        return $query;
    }
    public function getMotamed1($keyword=null)
    {
//        \DB::raw("CONCAT(name,'-',father_name) AS name

        $query   = $this->selectRaw("id,CONCAT(name,'-',father_name) AS full_name,father_name,position,name" )->limit(10);
        if($keyword){
            $query->where('motameds.name','like', '%' . $keyword . '%')
                  ->orWhere('motameds.last_name','like', '%' . $keyword . '%');
        }
        return $query->get();
    }
}
