<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ItemStatus extends Model
{
    protected $table="item_statuses";
    protected $filable=[
        'name_en',
        'name_ps',
        'name_prs',
    ];
}
