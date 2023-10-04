<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemSpec extends Model
{
    use HasFactory;
    protected $fillable =[
        'item_id',
        'specifications',
    ];

    public function getItemSpecs($item_id,$keyword=null)
    {
        $query  = $this->selectRaw("item_specs.*")
                       ->where('item_id',$item_id);
        if($keyword)
        {
            $query = $query->where('specifications','like', '%' . $keyword . '%') ;
        }
        return $query->get();
    }
}
