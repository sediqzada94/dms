<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DocCopy extends Model
{
    use HasFactory;
    protected $fillable = ['tracker_id', 'emp_id'];

    public function track():BelongsTo {
        return $this->BelongsTo(Tracker::class);
      }
}
