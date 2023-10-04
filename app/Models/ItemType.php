<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class ItemType extends Model
{
    protected $table = 'item_types';

    protected $fillable=[
      
        'name_prs',
        'name_en',
        'name_ps',
    ];
    public function items() {
        return $this->hasMany(Item::class);
    }
}
