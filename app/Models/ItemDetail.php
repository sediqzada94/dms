<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ItemDetail extends Model
{
    protected $table = 'item_details';

    protected $fillable=[
        'meem7_detail_id',
        'item_id',
        'measure_id',
        'spec_id',
        'serial_number',
        'tag_number',
        'barcode',
        'chassis',
        'engine',
        'number_palate',
        'model',
        'life_time_in_month'
    ];
}
