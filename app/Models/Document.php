<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Pagination\Paginator;
class Document extends Model
{
    use HasFactory;
    protected $fillable = ['title', 'remark'];
    public function trackers():HasMany {
      return $this->hasMany(Tracker::class);
    }


    public function getDocuments($request){
      $filter = $request->input('search_keyword');
      $per_page = $request->input('per_page') ? $request->input('per_page') : 10;
      $start_page = $request->input('current_page');
      $order_by = $request->input('order_by');
      $order_direction = $request->input('order_direction');
      // $fc9_number   = $request->fc9_number;
      // $date         = $request->date;
      // $directorate_id       = $request->directorate_id;
      //
      $query = $this;
      
      // $this->join('directorates', 'directorate_id', 'directorates.id')
      // ->selectRaw('DISTINCT fecen9s.*, ReturnLastFormFlow("fecen9_flows",fecen9s.id) as flow, 
      //             directorates.name_'.lang().' as dir_name');
      // ->orderBy('fecen9s.id', 'desc');

      if ($order_direction != '' || $order_by != '') {
          $query = $query->orderBy($order_by, $order_direction);
      }
      if ($filter != '') {
          $query = $query->where('fecen9s.fecen9_number', 'like', '%' . $filter . '%');
      }
      // if ($fc9_number != 'null') {
      //     $query = $query->where('fecen9s.fecen9_number', 'like', '%' . $fc9_number . '%');
      // }
      // if ($date != 'null') {
      //     $date = dateTomiladi($date);
      //     $query = $query->where('fecen9s.issue_date', $date);
      // }
      // if ($directorate_id != 'null') {
      //     $query = $query->where('fecen9s.directorate_id', $directorate_id);
      // }

      Paginator::currentPageResolver(function () use ($start_page) {
          return $start_page;
      });
      $query = $query->paginate($per_page);
      return $query;
  }

}