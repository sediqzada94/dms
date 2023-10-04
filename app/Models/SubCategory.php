<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubCategory extends Model
{
    use HasFactory;
    protected $table="sub_categories";
    protected $filable=[
        'category_id',
        'name_en',
        'name_ps',
        'name_prs'
    ];
    public function items() {
        return $this->hasMany(Item::class);
    }
    public function category() {
        return $this->belongsTo(Category::class);
    }
}
