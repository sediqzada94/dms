<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\Paginator;
class Heiat extends Model
{
    use HasFactory;
    protected $table='heiat_tashrih';
    protected $fillable=[
        'id',
        'start_date',
        'end_date',
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
    public function employee() {
        return $this->belongsTo(Employee::class);
    }
    public function HeiatList($request){
        $filter = $request->input('search_keyword');
        $per_page = $request->input('per_page') ? $request->input('per_page') : 10;
        $start_page = $request->input('current_page');
        $order_by = $request->input('order_by');
        $order_direction = $request->input('order_direction');
        $name   = $request->name;
        $directorate_id  = $request->directorate_id;
        $query = DB::table('heiat_tashrih')
        // ->leftJoin('employees', 'employees.id', '=', 'heiat_tashrih.employee_id')
        ->leftJoin('directorates', 'directorates.id', '=', 'heiat_tashrih.directorate_id')
        ->selectRaw('heiat_tashrih.*,directorates.name_'.lang().' as directorate_name,directorates.id as directorate_id
            ');
        if ($order_direction != '' || $order_by != '') {
            $query = $query->orderBy($order_by, $order_direction);
        }
        if ($filter != '') {
            $query->where('heiat_tashrih.name','like', '%' . $filter . '%')
            ->orWhere('heiat_tashrih.last_name','like', '%' . $filter . '%')
            ->orWhere('directorates.name_'.lang(),'like', '%' . $filter . '%')
            ->orWhereRaw('CONCAT(name, "-", father_name) LIKE ?', ['%' . $filter . '%']);
        }
      
        Paginator::currentPageResolver(function () use ($start_page) {
            return $start_page;
        });
        $query = $query->paginate($per_page);
        return $query;
    }
}
